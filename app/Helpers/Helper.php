<?php

use App\Exceptions\AccessPermissionDeniedException;
use App\Models\Course;
use App\Traits\GetGlobalInformationTrait;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use Modules\BasicPayment\app\Models\BasicPayment;
use Modules\Currency\app\Models\MultiCurrency;
use Modules\GlobalSetting\app\Models\CustomCode;
use Modules\GlobalSetting\app\Models\Setting;
use Modules\Language\app\Models\Language;
use Modules\Location\app\Models\Country;
use Modules\Order\app\Models\Enrollment;
use Modules\PaymentGateway\app\Models\PaymentGateway;
use Nwidart\Modules\Facades\Module;
use Spatie\LaravelImageOptimizer\Facades\ImageOptimizer;
use App\Mail\SubscriptionEmail;
use App\Models\CommitteeCategory;
use App\Models\Currency;
use App\Models\EmailTemplate;
use App\Models\FileManager;
use App\Models\Meta;
use App\Models\Notification;
use App\Models\SubscriptionEmailTemplate;
use App\Models\UserPackage;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Mail\EmailNotify;
use App\Models\Chat;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Mail;

function file_upload(UploadedFile $file, string $path = 'uploads/custom-images/', string | null $oldFile = '', bool $optimize = false) {
    $extention = $file->getClientOriginalExtension();
    $file_name = 'wsus-img' . date('-Y-m-d-h-i-s-') . rand(999, 9999) . '.' . $extention;
    $file_name = $path . $file_name;
    $file->move(public_path($path), $file_name);

    try {
        if ($oldFile && !str($oldFile)->contains('uploads/website-images') && File::exists(public_path($oldFile))) {
            File::delete(public_path($oldFile));
        }

        if ($optimize) {
            ImageOptimizer::optimize(public_path($file_name));
        }
    } catch (Exception $e) {
        Log::info($e->getMessage());
    }

    return $file_name;
}
// file upload method
if (!function_exists('allLanguages')) {
    function allLanguages() {
        $allLanguages = Cache::rememberForever('allLanguages', function () {
            return Language::select('code', 'name', 'direction', 'status')->get();
        });

        if (!$allLanguages) {
            $allLanguages = Language::select('code', 'name', 'direction', 'status')->get();
        }

        return $allLanguages;
    }
}

if (!function_exists('allCurrencies')) {
    function allCurrencies() {
        $allCurrencies = Cache::rememberForever('allCurrencies', function () {
            return MultiCurrency::all();
        });

        if (!$allCurrencies) {
            $allCurrencies = MultiCurrency::all();
        }

        return $allCurrencies;
    }
}

if (!function_exists('getSessionLanguage')) {
    function getSessionLanguage(): string {
        if (!session()->has('lang')) {
            session()->put('lang', config('app.locale'));
            session()->forget('text_direction');
            session()->put('text_direction', 'ltr');
        }

        $lang = Session::get('lang');

        return $lang;
    }
}

if (!function_exists('getSessionCurrency')) {
    function getSessionCurrency(): string {
        if (!session()->has('currency_code') || !session()->has('currency_rate') || !session()->has('currency_position')) {
            $currency = allCurrencies()->where('is_default', 'yes')->first();
            session()->put('currency_code', $currency->currency_code);
            session()->forget('currency_position');
            session()->put('currency_position', $currency->currency_position);
            session()->forget('currency_icon');
            session()->put('currency_icon', $currency->currency_icon);
            session()->forget('currency_rate');
            session()->put('currency_rate', $currency->currency_rate);
        }

        return Session::get('currency_code');
    }
}

function admin_lang() {
    return Session::get('admin_lang');
}
if (!function_exists('getSocialLinks')) {
    function getSocialLinks() {
        return Cache::rememberForever('getSocialLinks', function () {
            return \Modules\SocialLink\app\Models\SocialLink::select('link', 'icon')->get();
        });
    }
}

// calculate currency
function currency($price) {
    getSessionCurrency();
    $currency_icon = Session::get('currency_icon');
    $currency_rate = Session::has('currency_rate') ? Session::get('currency_rate') : 1;
    $currency_position = Session::get('currency_position');

    $price = $price * $currency_rate;
    $price = number_format($price, 2, '.', ',');

    if ($currency_position == 'before_price') {
        $price = $currency_icon . $price;
    } elseif ($currency_position == 'before_price_with_space') {
        $price = $currency_icon . ' ' . $price;
    } elseif ($currency_position == 'after_price') {
        $price = $price . $currency_icon;
    } elseif ($currency_position == 'after_price_with_space') {
        $price = $price . ' ' . $currency_icon;
    } else {
        $price = $currency_icon . $price;
    }

    return $price;
}

// calculate currency

if (!function_exists('userAuth')) {
    function userAuth() {
        return Auth::guard('web')->user();
    }
}
if (!function_exists('adminAuth')) {
    function adminAuth() {
        return Auth::guard('admin')->user();
    }
}

if (!function_exists('getPayableAmount')) {
    function getPayableAmount() {
    }
}
function payable_with_charges($amount): ?array {
    $availablePaymentMethods = [
        'stripe',
        'paypal',
        'razorpay',
        'mollie',
        'instamojo',
        'flutterwave',
        'paystack',
        'bank',
    ];

    getSessionCurrency();

    $currency_rate = Session::has('currency_rate') ? Session::get('currency_rate') : 1;

    $getGlobalInformationClass = new class
        {
        use GetGlobalInformationTrait;
    };

    $payable_with_charges = [];
    foreach ($availablePaymentMethods as $paymentMethod) {
        if ($paymentMethod == 'stripe' || $paymentMethod == 'paypal' || $paymentMethod == 'bank') {
            $basic_payment = $getGlobalInformationClass->get_basic_payment_info();
            $charge_property = $paymentMethod . '_charge';
            $gateway_charge = property_exists($basic_payment, $charge_property) ? $basic_payment->$charge_property : 0;
        } else {
            $payment_setting = $getGlobalInformationClass->get_payment_gateway_info();
            $charge_property = $paymentMethod . '_charge';
            $gateway_charge = property_exists($payment_setting, $charge_property) ? $payment_setting->$charge_property : 0;
        }

        $payable_amount = $amount * $currency_rate;
        $gateway_charge = $payable_amount * ($gateway_charge / 100);
        $payable_with_charge = $payable_amount + $gateway_charge;
        $payable_with_charges[$paymentMethod] = number_format(sprintf('%0.2f', $payable_with_charge));
    }

    return $payable_with_charges;
}

// custom decode and encode input value
function html_decode($text) {
    $after_decode = htmlspecialchars_decode($text, ENT_QUOTES);

    return $after_decode;
}

if (!function_exists('checkAdminHasPermission')) {
    function checkAdminHasPermission($permission): bool {
        return Auth::guard('admin')->user()->can($permission) ? true : false;
    }
}

if (!function_exists('checkAdminHasPermissionAndThrowException')) {
    function checkAdminHasPermissionAndThrowException($permission) {
        if (!checkAdminHasPermission($permission)) {
            throw new AccessPermissionDeniedException();
        }
    }
}

if (!function_exists('getSettingStatus')) {
    function getSettingStatus($key) {
        if (Cache::has('setting')) {
            $setting = Cache::get('setting');
            if (!is_null($key)) {
                return $setting->$key == 'active' ? true : false;
            }
        } else {
            try {
                return Setting::where('key', $key)->first()?->value == 'active' ? true : false;
            } catch (Exception $e) {
                if (app()->isLocal()) {
                    Log::info($e->getMessage());
                }

                return false;
            }
        }

        return false;
    }
}
if (!function_exists('checkCrentials')) {
    function checkCrentials() {
        if (Cache::has('setting') && $settings = Cache::get('setting')) {
            if ($settings->recaptcha_status !== 'inactive' && ($settings->recaptcha_site_key == 'recaptcha_site_key' || $settings->recaptcha_secret_key == 'recaptcha_secret_key' || $settings->recaptcha_site_key == '' || $settings->recaptcha_secret_key == '')) {
                return (object) [
                    'status'      => true,
                    'message'     => __('Google Recaptcha credentails not found'),
                    'description' => __('This may create a problem while submitting any form submission from website. Please fill up the credential from google account.'),
                    'route'       => 'admin.crediential-setting',
                ];
            }

            if ($settings->pixel_status !== 'inactive' && ($settings->pixel_app_id == 'pixel_app_id' || $settings->pixel_app_id == '')) {
                return (object) [
                    'status'      => true,
                    'message'     => __('Facebook Pixel credentails not found'),
                    'description' => __('This may create a problem to analyze your website. Please fill up the credential to avoid any problem.'),
                    'route'       => 'admin.crediential-setting',
                ];
            }

            if ($settings->facebook_login_status !== 'inactive' && ($settings->facebook_app_id == 'facebook_app_id' || $settings->facebook_app_secret == 'facebook_app_secret' || $settings->facebook_redirect_url == 'facebook_redirect_url' || $settings->facebook_app_id == '' || $settings->facebook_app_secret == '' || $settings->facebook_redirect_url == '')) {
                return (object) [
                    'status'      => true,
                    'message'     => __('Facebook login credentails not found'),
                    'description' => __('This may create a problem while logging in using facebook. Please fill up the credential to avoid any problem.'),
                    'route'       => 'admin.crediential-setting',
                ];
            }

            if ($settings->google_login_status !== 'inactive' && ($settings->gmail_client_id == 'gmail_client_id' || $settings->gmail_secret_id == 'gmail_secret_id' || $settings->gmail_client_id == '' || $settings->gmail_secret_id == '')) {
                return (object) [
                    'status'      => true,
                    'message'     => __('Google login credentails not found'),
                    'description' => __('This may create a problem while logging in using google. Please fill up the credential to avoid any problem.'),
                    'route'       => 'admin.crediential-setting',
                ];
            }

            if ($settings->google_tagmanager_status !== 'inactive' && ($settings->google_tagmanager_id == 'google_tagmanager_id' || $settings->google_tagmanager_id == '')) {
                return (object) [
                    'status'      => true,
                    'message'     => __('Google tag manager credentials not found'),
                    'description' => __('This may create a problem to analyze your website. Please fill up the credential to avoid any problem.'),
                    'route'       => 'admin.crediential-setting',
                ];
            }
            if ($settings->google_analytic_status !== 'inactive' && ($settings->google_analytic_id == 'google_analytic_id' || $settings->google_analytic_id == '')) {
                return (object) [
                    'status'      => true,
                    'message'     => __('Google analytic credentials not found'),
                    'description' => __('This may create a problem to analyze your website. Please fill up the credential to avoid any problem.'),
                    'route'       => 'admin.crediential-setting',
                ];
            }

            if ($settings->tawk_status !== 'inactive' && ($settings->tawk_chat_link == 'tawk_chat_link' || $settings->tawk_chat_link == '')) {
                return (object) [
                    'status'      => true,
                    'message'     => __('Tawk Chat Link credentails not found'),
                    'description' => __('This may create a problem to analyze your website. Please fill up the credential to avoid any problem.'),
                    'route'       => 'admin.crediential-setting',
                ];
            }

            if ($settings->pusher_status !== 'inactive' && ($settings->pusher_app_id == 'pusher_app_id' || $settings->pusher_app_key == 'pusher_app_key' || $settings->pusher_app_secret == 'pusher_app_secret' || $settings->pusher_app_cluster == 'pusher_app_cluster' || $settings->pusher_app_id == '' || $settings->pusher_app_key == '' || $settings->pusher_app_secret == '' || $settings->pusher_app_cluster == '')) {
                return (object) [
                    'status'      => true,
                    'message'     => __('Pusher credentails not found'),
                    'description' => __('This may create a problem while logging in using google. Please fill up the credential to avoid any problem.'),
                    'route'       => 'admin.crediential-setting',
                ];
            }

            if ($settings->mail_host == 'mail_host' || $settings->mail_username == 'mail_username' || $settings->mail_password == 'mail_password' || $settings->mail_host == '' || $settings->mail_port == '' || $settings->mail_username == '' || $settings->mail_password == '') {
                return (object) [
                    'status'      => true,
                    'message'     => __('Mail credentails not found'),
                    'description' => __('This may create a problem while sending email. Please fill up the credential to avoid any problem.'),
                    'route'       => 'admin.email-configuration',
                ];
            }
            if ($settings->wasabi_status !== 'inactive' && ($settings->wasabi_access_id == 'wasabi_access_id' || $settings->wasabi_access_id == '' || $settings->wasabi_secret_key == 'wasabi_secret_key' || $settings->wasabi_secret_key == '' || $settings->wasabi_bucket == 'wasabi_secret_key' || $settings->wasabi_bucket == '' || $settings->wasabi_region == 'wasabi_region' || $settings->wasabi_region == '')) {
                return (object) [
                    'status'      => true,
                    'message'     => __('Wasabi cloud storage credentials not found'),
                    'description' => __('This may create a problem to analyze your website. Please fill up the credential to avoid any problem.'),
                    'route'       => 'admin.crediential-setting',
                ];
            }
            if ($settings->aws_status !== 'inactive' && ($settings->aws_access_id == 'aws_access_id' || $settings->aws_access_id == '' || $settings->aws_secret_key == 'aws_secret_key' || $settings->aws_secret_key == '' || $settings->aws_bucket == 'aws_secret_key' || $settings->aws_bucket == '' || $settings->aws_region == 'aws_region' || $settings->aws_region == '')) {
                return (object) [
                    'status'      => true,
                    'message'     => __('AWS cloud storage credentials not found'),
                    'description' => __('This may create a problem to analyze your website. Please fill up the credential to avoid any problem.'),
                    'route'       => 'admin.crediential-setting',
                ];
            }
        }

        if (!Cache::has('basic_payment') && Module::isEnabled('BasicPayment')) {
            Cache::rememberForever('basic_payment', function () {
                $payment_info = BasicPayment::get();
                $basic_payment = [];
                foreach ($payment_info as $payment_item) {
                    $basic_payment[$payment_item->key] = $payment_item->value;
                }

                return (object) $basic_payment;
            });
        }

        if (Cache::has('basic_payment') && $basicPayment = Cache::get('basic_payment')) {
            if ($basicPayment->stripe_status !== 'inactive' && ($basicPayment->stripe_key == 'stripe_key' || $basicPayment->stripe_secret == 'stripe_secret' || $basicPayment->stripe_key == '' || $basicPayment->stripe_secret == '')) {

                return (object) [
                    'status'      => true,
                    'message'     => __('Stripe credentails not found'),
                    'description' => __('This may create a problem while making payment. Please fill up the credential to avoid any problem.'),
                    'route'       => 'admin.basicpayment',
                ];
            }

            if ($basicPayment->paypal_status !== 'inactive' && ($basicPayment->paypal_client_id == 'paypal_client_id' || $basicPayment->paypal_secret_key == 'paypal_secret_key' || $basicPayment->paypal_client_id == '' || $basicPayment->paypal_secret_key == '')) {
                return (object) [
                    'status'      => true,
                    'message'     => __('Paypal credentails not found'),
                    'description' => __('This may create a problem while making payment. Please fill up the credential to avoid any problem.'),
                    'route'       => 'admin.basicpayment',
                ];
            }
        }

        if (!Cache::has('payment_setting') && Module::isEnabled('PaymentGateway')) {
            Cache::rememberForever('payment_setting', function () {
                $payment_info = PaymentGateway::get();
                $payment_setting = [];
                foreach ($payment_info as $payment_item) {
                    $payment_setting[$payment_item->key] = $payment_item->value;
                }

                return (object) $payment_setting;
            });
        }

        if (Cache::has('payment_setting') && $paymentAddons = Cache::get('payment_setting')) {
            if ($paymentAddons->razorpay_status !== 'inactive' && ($paymentAddons->razorpay_key == 'razorpay_key' || $paymentAddons->razorpay_secret == 'razorpay_secret' || $paymentAddons->razorpay_key == '' || $paymentAddons->razorpay_secret == '')) {
                return (object) [
                    'status'      => true,
                    'message'     => __('Razorpay credentails not found'),
                    'description' => __('This may create a problem while making payment. Please fill up the credential to avoid any problem.'),
                    'route'       => 'admin.paymentgateway',
                ];
            }

            if ($paymentAddons->flutterwave_status !== 'inactive' && ($paymentAddons->flutterwave_public_key == 'flutterwave_public_key' || $paymentAddons->flutterwave_secret_key == 'flutterwave_secret_key' || $paymentAddons->flutterwave_public_key == '' || $paymentAddons->flutterwave_secret_key == '')) {
                return (object) [
                    'status'      => true,
                    'message'     => __('Flutterwave credentails not found'),
                    'description' => __('This may create a problem while making payment. Please fill up the credential to avoid any problem.'),
                    'route'       => 'admin.paymentgateway',
                ];
            }

            if ($paymentAddons->paystack_status !== 'inactive' && ($paymentAddons->paystack_public_key == 'paystack_public_key' || $paymentAddons->paystack_secret_key == 'paystack_secret_key' || $paymentAddons->paystack_public_key == '' || $paymentAddons->paystack_secret_key == '')) {
                return (object) [
                    'status'      => true,
                    'message'     => __('Paystack credentails not found'),
                    'description' => __('This may create a problem while making payment. Please fill up the credential to avoid any problem.'),
                    'route'       => 'admin.paymentgateway',
                ];
            }

            if ($paymentAddons->mollie_status !== 'inactive' && ($paymentAddons->mollie_key == 'mollie_key' || $paymentAddons->mollie_key == '')) {
                return (object) [
                    'status'      => true,
                    'message'     => __('Mollie credentails not found'),
                    'description' => __('This may create a problem while making payment. Please fill up the credential to avoid any problem.'),
                    'route'       => 'admin.paymentgateway',
                ];
            }

            if ($paymentAddons->instamojo_status !== 'inactive' && ($paymentAddons->instamojo_api_key == 'instamojo_api_key' || $paymentAddons->instamojo_auth_token == 'instamojo_auth_token' || $paymentAddons->instamojo_api_key == '' || $paymentAddons->instamojo_auth_token == '')) {
                return (object) [
                    'status'      => true,
                    'message'     => __('Instamojo credentails not found'),
                    'description' => __('This may create a problem while making payment. Please fill up the credential to avoid any problem.'),
                    'route'       => 'admin.paymentgateway',
                ];
            }
        }

        return false;
    }
}

if (!function_exists('isRoute')) {
    function isRoute(string | array $route, string $returnValue = null) {
        if (is_array($route)) {
            foreach ($route as $value) {
                if (Route::is($value)) {
                    return is_null($returnValue) ? true : $returnValue;
                }
            }
            return false;
        }

        if (Route::is($route)) {
            return is_null($returnValue) ? true : $returnValue;
        }

        return false;
    }
}
// get default language
if (!function_exists('getDefaultLanguage')) {
    function getDefaultLanguage(): string {
        // cache default language
        $defaultLanguage = Cache::rememberForever('defaultLanguage', function () {
            try {
                return Language::where('is_default', 1)->first()->code;
            } catch (\Exception $e) {
                info($e->getMessage());
                return 'en';
            }
        });

        return $defaultLanguage;
    }
}

/**
 * Set the tab step for the form
 *
 * @param string $name name of the tab session
 * @param string $step current step of the tab
 *
 * @return void
 */
if (!function_exists('setFormTabStep')) {
    function setFormTabStep(string $name, string $step): void {
        session()->flash($name, $step);
    }
}

/**
 * Get all countries from cache
 *
 * @return Collection all countries
 */
if (!function_exists('countries')) {
    function countries() {
        return Cache::rememberForever("countries", fn() => Country::all());
    }
}

if (!function_exists('instructorStatus')) {
    function instructorStatus() {
        return auth('web')->user()?->instructorInfo?->status;
    }
}
if (!function_exists('customCode')) {
    function customCode() {
        return Cache::rememberForever('customCode', function () {
            return CustomCode::select('css', 'header_javascript', 'javascript')->first();
        });
    }
}

/** Truncate string function */
if (!function_exists('truncate')) {
    function truncate($text, $limit = 60) {
        $text = $text ?? '';
        if (mb_strlen($text) > $limit) {
            return mb_substr($text, 0, $limit) . '...';
        }
        return $text;
    }
}

/** Format date function */
if (!function_exists('formatDate')) {
    function formatDate($date, $format = 'd M, Y') {
        return Carbon::parse($date)->format($format);
    }
}
if (!function_exists('formatTime')) {
    function formatTime($date, $format = 'h:i a') {
        return Carbon::parse($date)->format($format);
    }
}
if (!function_exists('formattedDateTime')) {
    function formattedDateTime($datetime) {
        return formatDate($datetime) . ' - ' . formatTime($datetime);
    }
}

/** Format minutes to hours */
if (!function_exists('minutesToHours')) {
    function minutesToHours($minutesToHours) {
        if ($minutesToHours === 0 || $minutesToHours === null) {
            return '--.--';
        }

        $hours = floor($minutesToHours / 60);
        $minutes = $minutesToHours % 60;
        return $hours . 'h ' . ($minutes ? $minutes . 'm' : '');
    }
}

/** Set enrollment ids in session */

if (!function_exists('setEnrollmentIdsInSession')) {
    function setEnrollmentIdsInSession() {
        if (auth('web')->check()) {
            $enrollmentsIds = Enrollment::where('user_id', userAuth()->id)->pluck('course_id')->toArray();
            session()->put('enrollments', $enrollmentsIds);
            return;
        }

        session()->put('enrollments', []);
    }
}
/** Set instructor course ids in session */

if (!function_exists('setInstructorCourseIdsInSession')) {
    function setInstructorCourseIdsInSession() {
        if (auth('web')->check() && userAuth()->role == 'instructor') {
            $enrollmentsIds = Course::where('instructor_id', userAuth()->id)->pluck('id')->toArray();
            session()->put('instructor_courses', $enrollmentsIds);
            return;
        }

        session()->put('instructor_courses', []);
    }
}

if (!function_exists('processText')) {
    function processText($text) {
        // Replace text within square brackets with a <span> tag
        $patternSquareBrackets = '/\[(.*?)\]/';
        $replacementSquareBrackets = '<span class="highlight">$1</span>';
        $text = preg_replace($patternSquareBrackets, $replacementSquareBrackets, $text);

        // Replace text within curly brackets with a <span> tag
        $patternCurlyBrackets = '/\{(.*?)\}/';
        $replacementCurlyBrackets = '<b>$1</b>';
        $text = preg_replace($patternCurlyBrackets, $replacementCurlyBrackets, $text);

        // Replace backslashes with <br> tags
        $patternBackslash = '/\\\\/';
        $replacementBackslash = '<br>';
        $text = preg_replace($patternBackslash, $replacementBackslash, $text);

        // Return the modified text
        return $text;
    }
}
function calculateReadingTime($content) {
    // Average reading speed (words per minute)
    $readingSpeed = 200;

    // Strip HTML tags and count the words
    $wordCount = str_word_count(strip_tags($content));

    // Calculate the reading time in minutes
    $readingTime = ceil($wordCount / $readingSpeed);

    return $readingTime;
}

if (!function_exists('getTags')) {
    function getTags($jsonTag = []) {
        $tags = $jsonTag;
        $tags_string = '';
        foreach ($tags as $tag) {
            $tags_string .= $tag->value . ',';
        }
        return $tags_string = rtrim($tags_string, ',');
    }
}
if (!function_exists('extractGoogleDriveVideoId')) {
    function extractGoogleDriveVideoId($url) {
        $googleDriveRegex = '/(?:https?:\/\/)?(?:www\.)?(?:drive\.google\.com\/(?:uc\?id=|file\/d\/|open\?id=)|youtu\.be\/)([\w-]{25,})[?=&#]*/';
        if (preg_match($googleDriveRegex, $url, $matches)) {
            return $matches[1];
        }
        return null;
    }
}

if (!function_exists('extractAndFilterImageSrc')) {
    function extractAndFilterImageSrc($string) {
        preg_match_all('/<img[^>]+src="([^">]+)"/i', $string, $matches);
        foreach (array_filter(array_map(function ($src) {
            $path = preg_replace('/^.*\/(uploads\/.*)$/', '$1', $src);
            return preg_match('/^uploads\/forum-images\/[^\/]+\.[a-zA-Z]{3,4}$/', $path) ? $path : null;
        }, $matches[1])) as $image) {
            $fullPath = public_path($image);
            if (File::exists($fullPath)) {
                File::delete($fullPath);
            }

        }
    }
}
if (!function_exists('replaceImageSources')) {
    function replaceImageSources($html) {
        $baseUrl = url('uploads/forum-images/');
        $pattern = '/<img\s+[^>]*src=["\']([^"\']+)["\'][^>]*>/i';

        $replacement = function ($matches) use ($baseUrl) {
            $existingSrc = $matches[1];
            $newSrc = $baseUrl . '/' . basename($existingSrc);
            return str_replace($existingSrc, $newSrc, $matches[0]);
        };
        $newHtml = preg_replace_callback($pattern, $replacement, $html);
        return $newHtml;
    }
}
if (!function_exists('routeList')) {
    function routeList(): object {
        $route_list = [
            (object) ['name' => __('Dashboard'), 'route' => route('admin.dashboard'), 'permission' => 'dashboard.view'],
            (object) ['name' => __('Courses'), 'route' => route('admin.courses.index'), 'permission' => 'course.management'],
            (object) ['name' => __('Course Categories'), 'route' => route('admin.course-category.index'), 'permission' => 'course.management'],
            (object) ['name' => __('Course languages'), 'route' => route('admin.course-language.index'), 'permission' => 'course.management'],
            (object) ['name' => __('Course levels'), 'route' => route('admin.course-level.index'), 'permission' => 'course.management'],
            (object) ['name' => __('Course Reviews'), 'route' => route('admin.course-review.index'), 'permission' => 'course.management'],
            (object) ['name' => __('Course Delete Requests'), 'route' => route('admin.course-delete-request.index'), 'permission' => 'course.management'],
            (object) ['name' => __('Certificate Builder'), 'route' => route('admin.certificate-builder.index'), 'permission' => 'course.certificate.management'],
            (object) ['name' => __('Badges'), 'route' => route('admin.badges.index'), 'permission' => 'badge.management'],
            // (object) ['name' => __('Blog Categories'), 'route' => route('admin.blog-category.index'), 'permission' => 'blog.category.view'],
            // (object) ['name' => __('Blog List'), 'route' => route('admin.blogs.index'), 'permission' => 'blog.view'],
            // (object) ['name' => __('Blog Comments'), 'route' => route('admin.blog-comment.index'), 'permission' => 'blog.comment.view'],
            (object) ['name' => __('Order History'), 'route' => route('admin.orders'), 'permission' => 'order.management'],
            (object) ['name' => __('Pending Payment'), 'route' => route('admin.pending-orders'), 'permission' => 'order.management'],
            (object) ['name' => __('Coupon List'), 'route' => route('admin.coupon.index'), 'permission' => 'coupon.management'],
            // (object) ['name' => __('Withdraw Method'), 'route' => route('admin.withdraw-method.index'), 'permission' => 'withdraw.management'],
            // (object) ['name' => __('Withdraw list'), 'route' => route('admin.withdraw-list'), 'permission' => 'withdraw.management'],
            (object) ['name' => __('Instructor Request List'), 'route' => route('admin.instructor-request.index'), 'permission' => 'instructor.request.list'],
            (object) ['name' => __('Instructor Request Settings'), 'route' => route('admin.instructor-request-setting.index'), 'permission' => 'instructor.request.list'],
            (object) ['name' => __('All Students'), 'route' => route('admin.all-customers'), 'permission' => 'customer.view'],
            (object) ['name' => __('All Instructors'), 'route' => route('admin.all-instructors'), 'permission' => 'customer.view'],
            (object) ['name' => __('Active Users'), 'route' => route('admin.active-customers'), 'permission' => 'customer.view'],
            (object) ['name' => __('Non verified Users'), 'route' => route('admin.non-verified-customers'), 'permission' => 'customer.view'],
            (object) ['name' => __('Banned Users'), 'route' => route('admin.banned-customers'), 'permission' => 'customer.view'],
            (object) ['name' => __('Send bulk mail Users'), 'route' => route('admin.send-bulk-mail'), 'permission' => 'customer.view'],
            (object) ['name' => __('Countries'), 'route' => route('admin.country.index'), 'permission' => 'location.view'],
            // (object) ['name' => __('Site Themes'), 'route' => route('admin.site-appearance.index'), 'permission' => 'appearance.management'],
            // (object) ['name' => __('Section Setting'), 'route' => route('admin.section-setting.index'), 'permission' => 'appearance.management'],
            // (object) ['name' => __('Site Colors'), 'route' => route('admin.site-color-setting.index'), 'permission' => 'appearance.management'],
            // (object) ['name' => __('Hero Section'), 'route' => route('admin.hero-section.edit', ['hero_section' => 1, 'code' => 'en']), 'permission' => 'section.management'],
            // (object) ['name' => __('About Section'), 'route' => route('admin.about-section.edit', ['about_section' => 1, 'code' => 'en']), 'permission' => 'section.management'],
            // (object) ['name' => __('Featured Course Section'), 'route' => route('admin.featured-course-section.index'), 'permission' => 'section.management'],
            // (object) ['name' => __('Newsletter Section'), 'route' => route('admin.newsletter-section.index'), 'permission' => 'section.management'],
            // (object) ['name' => __('Featured Instructor'), 'route' => route('admin.featured-instructor-section.edit', ['featured_instructor_section' => 1, 'code' => 'en']), 'permission' => 'section.management'],
            // // (object) ['name' => __('Counter Section'), 'route' => route('admin.counter-section.index'), 'permission' => 'section.management'],
            // // (object) ['name' => __('Faq Section'), 'route' => route('admin.faq-section.edit', ['faq_section' => 1, 'code' => 'en']), 'permission' => 'section.management'],
            // // (object) ['name' => __('Our Features Section'), 'route' => route('admin.our-features-section.edit', ['our_features_section' => 1, 'code' => 'en']), 'permission' => 'section.management'],
            // // (object) ['name' => __('Banner Section'), 'route' => route('admin.banner-section.index'), 'permission' => 'section.management'],
            // (object) ['name' => __('Contact Page Section'), 'route' => route('admin.contact-section.index'), 'permission' => 'section.management'],
            // (object) ['name' => __('Brands'), 'route' => route('admin.brand.index'), 'permission' => 'brand.managemen'],
            // (object) ['name' => __('Footer Setting'), 'route' => route('admin.footersetting.index'), 'permission' => 'footer.management'],
            // (object) ['name' => __('Menu Builder'), 'route' => route('admin.menubuilder.index'), 'permission' => 'menu.view'],
            // (object) ['name' => __('Page Builder'), 'route' => route('admin.page-builder.index'), 'permission' => 'page.management'],
            (object) ['name' => __('Social Links'), 'route' => route('admin.social-link.index'), 'permission' => 'social.link.management'],
            // (object) ['name' => __('FAQS'), 'route' => route('admin.faq.index'), 'permission' => 'faq.view'],
            // (object) ['name' => __('Subscriber List'), 'route' => route('admin.subscriber-list'), 'permission' => 'newsletter.view'],
            // (object) ['name' => __('Subscriber Send bulk mail'), 'route' => route('admin.send-mail-to-newsletter'), 'permission' => 'newsletter.view'],
            // (object) ['name' => __('Testimonial'), 'route' => route('admin.testimonial.index'), 'permission' => 'testimonial.view'],
            (object) ['name' => __('Contact Messages'), 'route' => route('admin.contact-messages'), 'permission' => 'contect.message.view'],
            (object) ['name' => __('General Settings'), 'route' => route('admin.general-setting'), 'permission' => 'setting.view', 'tab' => 'general_tab'],
            (object) ['name' => __('Logo & Favicon'), 'route' => route('admin.general-setting'), 'permission' => 'setting.view', 'tab' => 'logo_favicon_tab'],
            (object) ['name' => __('Cookie Consent'), 'route' => route('admin.general-setting'), 'permission' => 'setting.view', 'tab' => 'cookie_consent_tab'],
            (object) ['name' => __('Breadcrumb image'), 'route' => route('admin.general-setting'), 'permission' => 'setting.view', 'tab' => 'breadcrump_img_tab'],
            (object) ['name' => __('Copyright Text'), 'route' => route('admin.general-setting'), 'permission' => 'setting.view', 'tab' => 'copyright_text_tab'],
            (object) ['name' => __('Maintenance Mode'), 'route' => route('admin.general-setting'), 'permission' => 'setting.view', 'tab' => 'mmaintenance_mode_tab'],
            (object) ['name' => __('Credential Settings'), 'route' => route('admin.crediential-setting'), 'permission' => 'setting.view', 'tab' => 'google_recaptcha_tab'],
            (object) ['name' => __('Google reCaptcha'), 'route' => route('admin.crediential-setting'), 'permission' => 'setting.view', 'tab' => 'google_recaptcha_tab'],
            (object) ['name' => __('Google Tag Manager'), 'route' => route('admin.crediential-setting'), 'permission' => 'setting.view', 'tab' => 'google_tag_tab'],
            (object) ['name' => __('Wasabi Cloud Storage'), 'route' => route('admin.crediential-setting'), 'permission' => 'setting.view', 'tab' => 'wasabi_tab'],
            (object) ['name' => __('AWS Cloud Storage'), 'route' => route('admin.crediential-setting'), 'permission' => 'setting.view', 'tab' => 'aws_tab'],
            (object) ['name' => __('Google Analytic'), 'route' => route('admin.crediential-setting'), 'permission' => 'setting.view', 'tab' => 'google_analytic_tab'],
            (object) ['name' => __('Facebook Pixel'), 'route' => route('admin.crediential-setting'), 'permission' => 'setting.view', 'tab' => 'facebook_pixel_tab'],
            (object) ['name' => __('Social Login'), 'route' => route('admin.crediential-setting'), 'permission' => 'setting.view', 'tab' => 'social_login_tab'],
            (object) ['name' => __('Tawk Chat'), 'route' => route('admin.crediential-setting'), 'permission' => 'setting.view', 'tab' => 'tawk_chat_tab'],
            (object) ['name' => __('Email Configuration'), 'route' => route('admin.email-configuration'), 'permission' => 'setting.view', 'tab' => 'setting_tab'],
            (object) ['name' => __('Email Template'), 'route' => route('admin.email-configuration'), 'permission' => 'setting.view', 'tab' => 'email_template_tab'],
            (object) ['name' => __('SEO Setup'), 'route' => route('admin.seo-setting'), 'permission' => 'setting.view'],
            (object) [
                'name'       => __('Custom CSS'),
                'route'      => route('admin.custom-code', ['type' => 'css']),
                'permission' => 'setting.view',
            ],
            (object) [
                'name'       => __('Custom JS'),
                'route'      => route('admin.custom-code', ['type' => 'js']),
                'permission' => 'setting.view',
            ],
            (object) [
                'name'       => __('Marketing Settings'),
                'route'      => route('admin.marketing-setting'),
                'permission' => 'setting.view',
            ],
            (object) ['name' => __('Clear cache'), 'route' => route('admin.cache-clear'), 'permission' => 'setting.view'],
            (object) ['name' => __('Database Clear'), 'route' => route('admin.database-clear'), 'permission' => 'setting.view'],
            (object) ['name' => __('System Update'), 'route' => route('admin.system-update.index'), 'permission' => 'setting.view'],
            (object) ['name' => __('Admin Commission'), 'route' => route('admin.commission-setting'), 'permission' => 'setting.view'],
            (object) ['name' => __('Manage Language'), 'route' => route('admin.languages.index'), 'permission' => 'language.view'],
            (object) ['name' => __('More Gateways'), 'route' => route('admin.paymentgateway'), 'permission' => 'payment.view'],
            // (object) ['name' => __('Basic Payment'), 'route' => route('admin.basicpayment'), 'permission' => 'basic.payment.view'],
            (object) ['name' => __('Multi Currency'), 'route' => route('admin.currency.index'), 'permission' => 'currency.view'],
            (object) ['name' => __('Manage Admin'), 'route' => route('admin.admin.index'), 'permission' => 'admin.view'],
            (object) ['name' => __('Role & Permissions'), 'route' => route('admin.role.index'), 'permission' => 'role.view'],
        ];
        usort($route_list, function ($a, $b) {
            return strcmp($a->name, $b->name);
        });

        return (object) $route_list;
    }
}
//wasabi config setup
if (!function_exists('set_wasabi_config')) {
    function set_wasabi_config() {
        $wasabi_setting = Cache::get('setting');
        config(['filesystems.disks.wasabi.key' => $wasabi_setting?->wasabi_access_id]);
        config(['filesystems.disks.wasabi.secret' => $wasabi_setting?->wasabi_secret_key]);
        config(['filesystems.disks.wasabi.bucket' => $wasabi_setting?->wasabi_bucket]);
        config(['filesystems.disks.wasabi.region' => $wasabi_setting?->wasabi_region]);
    }
}
if (!function_exists('set_aws_config')) {
    function set_aws_config() {
        $aws_setting = Cache::get('setting');
        config(['filesystems.disks.aws.key' => $aws_setting?->aws_access_id]);
        config(['filesystems.disks.aws.secret' => $aws_setting?->aws_secret_key]);
        config(['filesystems.disks.aws.bucket' => $aws_setting?->aws_bucket]);
        config(['filesystems.disks.aws.region' => $aws_setting?->aws_region]);
        config(['filesystems.disks.aws.url' => "https://{$aws_setting?->aws_bucket}.s3.amazonaws.com/"]);
    }
}
if (!function_exists('manageAssetImage')) {
    /**
     * Return the appropriate image URL based on app mode.
     *
     * @param string|null $staticUrl
     * @param string|null $dynamicUrl
     * @return string|null
     */
    function manageAssetImage($staticUrl = null, $dynamicUrl = null) {
        if (!$dynamicUrl) return null;

        // Check if the app is in demo mode and the static URL file exists
        if (strtolower(config('app.app_mode')) == 'demo' && $staticUrl && file_exists(public_path($staticUrl))) {
            return asset($staticUrl);
        }
        // Return the dynamic URL
        return asset($dynamicUrl);
    }
}
if (!function_exists("getOption")) {
    function getOption($option_key, $default = NULL)
    {
        $system_settings = config('settings');

        if ($option_key && isset($system_settings[$option_key])) {
            return $system_settings[$option_key];
        } else {
            return $default;
        }
    }
}

if (!function_exists("getCommitteeCategoryMenu")) {
    function getCommitteeCategoryMenu()
    {
      $committeeCategory =  CommitteeCategory::where(['status' => STATUS_ACTIVE, 'showing_home_page' => STATUS_ACTIVE, 'tenant_id' => getTenantId()])->get();

      return $committeeCategory;
    }
}

function getSettingImage($option_key)
{

    if ($option_key && $option_key != null) {


        $setting = Setting::where('tenant_id', getTenantId())->where('option_key', $option_key)->first();
        if (isset($setting->option_value) && isset($setting->option_value) != null) {

            $file = FileManager::where('tenant_id', getTenantId())->select('path', 'storage_type')->find($setting->option_value);


            if (!is_null($file)) {
                if (Storage::disk($file->storage_type)->exists($file->path)) {

                    if ($file->storage_type == 'public') {
                        return asset('storage/' . $file->path);
                    }

                    return Storage::disk($file->storage_type)->url($file->path);
                }
            }
        }
    }
    return asset('assets/images/no-image.jpg');
}

function getSettingImageCentral($option_key)
{

    if ($option_key && $option_key != null) {


        $setting = Setting::where('tenant_id', NULL)->where('option_key', $option_key)->first();
        if (isset($setting->option_value) && isset($setting->option_value) != null) {

            $file = FileManager::where('tenant_id', NULL)->select('path', 'storage_type')->find($setting->option_value);


            if (!is_null($file)) {
                if (Storage::disk($file->storage_type)->exists($file->path)) {

                    if ($file->storage_type == 'public') {
                        return asset('storage/' . $file->path);
                    }

                    return Storage::disk($file->storage_type)->url($file->path);
                }
            }
        }
    }
    return asset('assets/images/no-image.jpg');
}

function settingImageStoreUpdate($option_value, $requestFile)
{

    if ($requestFile) {

        /*File Manager Call upload*/
        if ($option_value && $option_value != null) {
            $new_file = FileManager::where('tenant_id', getTenantId())->where('id', $option_value)->first();

            if ($new_file) {
                $new_file->removeFile();
                $uploaded = $new_file->upload('Setting', $requestFile, '', $new_file->id);
            } else {
                $new_file = new FileManager();
                $uploaded = $new_file->upload('Setting', $requestFile);
            }
        } else {
            $new_file = new FileManager();
            $uploaded = $new_file->upload('Setting', $requestFile);
        }

        /*End*/

        return $uploaded->id;
    }

    return null;
}


if (!function_exists("getDefaultImage")) {
    function getDefaultImage()
    {
        // return asset('assets/images/no-image.jpg');
        return asset('assets/images/icon/upload-img-1.svg');
    }
}


if (!function_exists("toastMessage")) {
    function toastMessage($message_type, $message)
    {
        Toastr::$message_type($message, '', ['progressBar' => true, 'closeButton' => true, 'positionClass' => 'toast-top-right']);
    }
}

if (!function_exists("getDefaultLanguage")) {
    function getDefaultLanguage()
    {
        $language = Language::where('default', STATUS_ACTIVE)->first();
        if ($language) {
            $iso_code = $language->iso_code;
            return $iso_code;
        }

        return 'en';
    }
}

if (!function_exists("getCurrencySymbol")) {
    function getCurrencySymbol($tenantId = NULL)
    {
        $currency = Currency::where('tenant_id', getTenantId() ?? $tenantId)->where('current_currency', STATUS_ACTIVE)->first();
        if ($currency) {
            $symbol = $currency->symbol;
            return $symbol;
        }

        return '';
    }
}

if (!function_exists("getIsoCode")) {
    function getIsoCode($tenantId = NULL)
    {
        $currency = Currency::where('tenant_id', getTenantId() ?? $tenantId)->where('current_currency', STATUS_ACTIVE)->first();
        if ($currency) {
            $currency_code = $currency->currency_code;
            return $currency_code;
        }

        return '';
    }
}

if (!function_exists("getCurrencyPlacement")) {
    function getCurrencyPlacement($tenantId = NULL)
    {
        $currency = Currency::where('tenant_id', getTenantId() ?? $tenantId)->where('current_currency', STATUS_ACTIVE)->first();
        $placement = 'before';
        if ($currency) {
            $placement = $currency->currency_placement;
            return $placement;
        }

        return $placement;
    }
}

if (!function_exists("showPrice")) {
    function showPrice($price)
    {
        $price = getNumberFormat($price);
        if (config('app.currencyPlacement') == 'after') {
            return $price . config('app.currencySymbol');
        } else {
            return config('app.currencySymbol') . $price;
        }
    }
}


if (!function_exists("getNumberFormat")) {
    function getNumberFormat($amount)
    {
        return number_format($amount, 2, '.', '');
    }
}

if (!function_exists("decimalToInt")) {
    function decimalToInt($amount)
    {
        return number_format(number_format($amount, 2, '.', '') * 100, 0, '.', '');
    }
}

if (!function_exists("intToDecimal")) {
}
function intToDecimal($amount)
{
    return number_format($amount / 100, 2, '.', '');
}

if (!function_exists("appLanguages")) {
    function appLanguages()
    {
        return Language::where('status', 1)->get();
    }
}

if (!function_exists("selectedLanguage")) {
    function selectedLanguage()
    {

        $language = Language::where('iso_code', session()->get('local'))->first();

        if (!$language) {
            $language = Language::first();
            if ($language) {
                $ln = $language->iso_code;
                session(['local' => $ln]);
                App::setLocale(session()->get('local'));
            }
        }

        return $language;
    }
}

if (!function_exists("getVideoFile")) {
    function getFile($path, $storageType)
    {
        if (!is_null($path)) {
            if (Storage::disk($storageType)->exists($path)) {

                if ($storageType == 'public') {
                    return asset('storage/' . $path);
                }

                if ($storageType == 'wasabi') {
                    return Storage::disk('wasabi')->url($path);
                }


                return Storage::disk($storageType)->url($path);
            }
        }

        return asset('assets/images/no-image.jpg');
    }
}

if (!function_exists("notificationForUser")) {
    function notificationForUser()
    {
        $instructor_notifications = \App\Models\Notification::where('user_id', auth()->user()->id)->where('user_type', 2)->where('is_seen', 'no')->orderBy('created_at', 'DESC')->get();
        $student_notifications = \App\Models\Notification::where('user_id', auth()->user()->id)->where('user_type', 3)->where('is_seen', 'no')->orderBy('created_at', 'DESC')->get();
        return array('instructor_notifications' => $instructor_notifications, 'student_notifications' => $student_notifications);
    }
}

if (!function_exists("adminNotifications")) {
    function adminNotifications()
    {
        return \App\Models\Notification::where('tenant_id', getTenantId())->where('user_type', 1)->where('is_seen', 'no')->orderBy('created_at', 'DESC')->paginate(5);
    }
}

if (!function_exists('getSlug')) {
    function getSlug($text)
    {
        if ($text) {
            $text = preg_replace("/[\n\t]/", " ", $text);
            $data = preg_replace("/[~`{}.'\"\!\@\#\$\%\^\&\*\(\)\_\=\+\/\?\>\<\,\[\]\:\;\|\\\]/", "", $text);
            $slug = preg_replace("/[\/_|+ -]+/", "-", $data);
            return $slug;
        }
        return '';
    }
}


if (!function_exists('getCustomerCurrentBuildVersion')) {
    function getCustomerCurrentBuildVersion()
    {
        $buildVersion = getOption('build_version');

        if (is_null($buildVersion)) {
            return 1;
        }

        return (int)$buildVersion;
    }
}

if (!function_exists('getCustomerAddonBuildVersion')) {
    function getCustomerAddonBuildVersion($code)
    {
        $buildVersion = getOption($code . '_build_version', 0);
        if (is_null($buildVersion)) {
            return 0;
        }
        return (int)$buildVersion;
    }
}

if (!function_exists('isAddonInstalled')) {
    function isAddonInstalled($code)
    {
        // return false;
        $buildVersion = getOption($code . '_build_version', 0);
        $codeBuildVersion = getAddonCodeBuildVersion($code);
        if ($buildVersion == 0 || $codeBuildVersion == 0) {
            return false;
        }
        return true;
    }
}

if (!function_exists('setCustomerAddonCurrentVersion')) {
    function setCustomerAddonCurrentVersion($code)
    {
        $option = Setting::firstOrCreate(['option_key' => $code . '_current_version']);
        $option->option_value = getAddonCodeCurrentVersion($code);
        $option->save();
    }
}

if (!function_exists('setCustomerAddonBuildVersion')) {
    function setCustomerAddonBuildVersion($code, $version)
    {
        $option = Setting::firstOrCreate(['option_key' => $code . '_build_version']);
        $option->option_value = $version;
        $option->save();
    }
}


if (!function_exists('getAddonCodeCurrentVersion')) {
    function getAddonCodeCurrentVersion($appCode)
    {
        Artisan::call("optimize:clear");
        return config('Addon.' . $appCode . '.current_version', 0);
    }
}

if (!function_exists('getAddonCodeBuildVersion')) {
    function getAddonCodeBuildVersion($appCode)
    {
        Artisan::call("optimize:clear");
        return config('Addon.' . $appCode . '.build_version', 0);
    }
}

if (!function_exists('setCustomerBuildVersion')) {
    function setCustomerBuildVersion($version)
    {
        $option = Setting::firstOrCreate(['option_key' => 'build_version']);
        $option->option_value = $version;
        $option->save();
    }
}

if (!function_exists('setCustomerCurrentVersion')) {
    function setCustomerCurrentVersion()
    {
        $option = Setting::firstOrCreate(['option_key' => 'current_version']);
        $option->option_value = config('app.current_version');
        $option->save();
    }
}


if (!function_exists('getDomainName')) {
    function getDomainName($url)
    {
        $parseUrl = parse_url(trim($url));
        if (isset($parseUrl['host'])) {
            $host = $parseUrl['host'];
        } else {
            $path = explode('/', $parseUrl['path']);
            $host = $path[0];
        }
        return trim($host);
    }
}


if (!function_exists('updateEnv')) {
    function updateEnv($values)
    {
        if (count($values) > 0) {
            foreach ($values as $envKey => $envValue) {
                setEnvironmentValue($envKey, $envValue);
            }
            return true;
        }
    }
}

if (!function_exists('setEnvironmentValue')) {
    function setEnvironmentValue($envKey, $envValue)
    {
        try {
            $envFile = app()->environmentFilePath();
            $str = file_get_contents($envFile);
            $str .= "\n"; // In case the searched variable is in the last line without \n
            $keyPosition = strpos($str, "{$envKey}=");
            if ($keyPosition) {
                if (PHP_OS_FAMILY === 'Windows') {
                    $endOfLinePosition = strpos($str, "\n", $keyPosition);
                } else {
                    $endOfLinePosition = strpos($str, PHP_EOL, $keyPosition);
                }
                $oldLine = substr($str, $keyPosition, $endOfLinePosition - $keyPosition);
                $envValue = str_replace(chr(92), "\\\\", $envValue);
                $envValue = str_replace('"', '\"', $envValue);
                $newLine = "{$envKey}=\"{$envValue}\"";
                if ($oldLine != $newLine) {
                    $str = str_replace($oldLine, $newLine, $str);
                    $str = substr($str, 0, -1);
                    $fp = fopen($envFile, 'w');
                    fwrite($fp, $str);
                    fclose($fp);
                }
            } else if (strtoupper($envKey) == $envKey) {
                $envValue = str_replace(chr(92), "\\\\", $envValue);
                $envValue = str_replace('"', '\"', $envValue);
                $newLine = "{$envKey}=\"{$envValue}\"\n";
                $str .= $newLine;
                $str = substr($str, 0, -1);
                $fp = fopen($envFile, 'w');
                fwrite($fp, $str);
                fclose($fp);
            }
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }
}

if (!function_exists('base64urlEncode')) {
    function base64urlEncode($str)
    {
        return rtrim(strtr(base64_encode($str), '+/', '-_'), '=');
    }
}

if (!function_exists('getTimeZone')) {
    function getTimeZone()
    {
        return DateTimeZone::listIdentifiers(
            DateTimeZone::ALL
        );
    }
}

if (!function_exists('getErrorMessage')) {
    function getErrorMessage($e, $customMsg = null)
    {
        if ($customMsg != null) {
            return $customMsg;
        }
        if (env('APP_DEBUG')) {
            return $e->getMessage() . $e->getLine();
        } else {
            return SOMETHING_WENT_WRONG;
        }
    }
}

if (!function_exists('getFileUrl')) {
    function getFileUrl($id = null)
    {

        $file = FileManager::select('path', 'storage_type')->find($id);

        if (!is_null($file)) {
            if (Storage::disk($file->storage_type)->exists($file->path)) {

                if ($file->storage_type == 'public') {
                    return asset('storage/' . $file->path);
                }

                if ($file->storage_type == 'wasabi') {
                    return Storage::disk('wasabi')->url($file->path);
                }


                return Storage::disk($file->storage_type)->url($file->path);
            }
        }

        return asset('assets/images/no-image.jpg');
    }
}

if (!function_exists('languageLocale')) {
    function languageLocale($locale)
    {
        $data = Language::where('code', $locale)->first();
        if ($data) {
            return $data->code;
        }
        return 'en';
    }
}


if (!function_exists('getUseCase')) {
    function getUseCase($useCase = [])
    {
        if (in_array("-1", $useCase)) {
            return __("All");
        }
        return count($useCase);
    }
}

function currentCurrency($attribute = '')
{
    $currentCurrency = Currency::where('tenant_id', getTenantId())->where('current_currency', 1)->first();
    if (isset($currentCurrency->{$attribute})) {
        return $currentCurrency->{$attribute};
    }
    return '';
}

function currentCurrencyType()
{
    $currentCurrency = Currency::where('tenant_id', getTenantId())->where('current_currency', 1)->first();
    return $currentCurrency?->currency_code;
}

function currentCurrencyIcon()
{
    $currentCurrency = Currency::where('tenant_id', getTenantId())->where('current_currency', 1)->first();
    return $currentCurrency->symbol;
}

function convertCurrencySwap($amount, $to = 'USD', $from = 'USD')
{
    try {
        $jsondata = "";

        $coinPriceInCurrency = Setting::where('option_key', 'COIN_PRICE_IN_CURRENCY_FOR' . $from)->first();
        if ($coinPriceInCurrency != null) {

            if ($coinPriceInCurrency->option_value == null) {
                $url = "https://min-api.cryptocompare.com/data/price?fsym=$from&tsyms=$to";
                $json = file_get_contents($url); //,FALSE,$ctx);
                $jsondata =  json_decode($json, TRUE);

                $coinPriceInCurrency->option_value = $jsondata[$to];
                $coinPriceInCurrency->save();
            }

            $dateTime = Carbon::now()->addMinute(5);
            $currentTime = $dateTime->format('Y-m-d H:i:s');

            if (($coinPriceInCurrency->option_value != null) && (date('Y-m-d H:i:s', strtotime($coinPriceInCurrency->updated_at)) < $currentTime)) {
                $url = "https://min-api.cryptocompare.com/data/price?fsym=$from&tsyms=$to";
                $json = file_get_contents($url); //,FALSE,$ctx);
                $jsondata =  json_decode($json, TRUE);

                $coinPriceInCurrency->option_value = $jsondata[$to];
                $coinPriceInCurrency->save();
            }
        } else {

            $url = "https://min-api.cryptocompare.com/data/price?fsym=$from&tsyms=$to";
            $json = file_get_contents($url); //,FALSE,$ctx);
            $jsondata =  json_decode($json, TRUE);

            if ($jsondata != null) {
                $newObj = new Setting();
                $newObj->option_key = 'COIN_PRICE_IN_CURRENCY_FOR' . $from;
                $newObj->option_value = $jsondata[$to];
                $newObj->save();
            }
        }

        return [
            'total' => $amount * getOption('COIN_PRICE_IN_CURRENCY_FOR' . $from),
            'price' => getOption('COIN_PRICE_IN_CURRENCY_FOR' . $from)
        ];
    } catch (\Exception $e) {
        return [
            'total' => 0.00000000,
            'price' => 0.00000000
        ];
    }
}

function random_strings($length_of_string)
{
    $str_result = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890abcdefghijklmnopqrstuvwxyz';
    return substr(str_shuffle($str_result), 0, $length_of_string);
}

function broadcastPrivate($eventName, $broadcastData, $userId)
{
    //    $channelName = 'private-'.env("PUSHER_PRIVATE_CHANEL_NAME").'.' . customEncrypt($userId);
    //    dispatch(new BroadcastJob($channelName, $eventName, $broadcastData))->onQueue('broadcast-data');
}

function getUserId()
{
    try {
        return Auth::id();
    } catch (\Exception $e) {
        return 0;
    }
}


if (!function_exists('visual_number_format')) {
    function visual_number_format($value)
    {
        if (is_integer($value)) {
            return number_format($value, 2, '.', '');
        } elseif (is_string($value)) {
            $value = floatval($value);
        }
        $number = explode('.', number_format($value, 10, '.', ''));
        $intVal = (int)$value;
        if ($value > $intVal || $value < 0) {
            $intPart = $number[0];
            $floatPart = substr($number[1], 0, 8);
            $floatPart = rtrim($floatPart, '0');
            if (strlen($floatPart) < 2) {
                $floatPart = substr($number[1], 0, 2);
            }
            return $intPart . '.' . $floatPart;
        }
        return $number[0] . '.' . substr($number[1], 0, 2);
    }
}

function getError($e)
{
    if (env('APP_DEBUG')) {
        return " => " . $e->getMessage();
    }
    return '';
}

function notification($title = null, $body = null, $user_id = null, $link = null)
{
    try {
        $obj = new Notification();
        $obj->title = $title;
        $obj->body = $body;
        $obj->user_id = $user_id;
        $obj->link = $link;
        $obj->save();
        return "notification sent!";
    } catch (\Exception $e) {
        return "something error!";
    }
}

if (!function_exists('get_default_language')) {
    function get_default_language()
    {
        $language = Language::where('default', STATUS_ACTIVE)->first();
        if ($language) {
            $iso_code = $language->iso_code;
            return $iso_code;
        }

        return 'en';
    }
}

if (!function_exists('get_currency_symbol')) {
    function get_currency_symbol()
    {
        $currency = Currency::where('tenant_id', getTenantId())->where('current_currency', STATUS_ACTIVE)->first();
        if ($currency) {
            $symbol = $currency->symbol;
            return $symbol;
        }

        return '';
    }
}

if (!function_exists('get_currency_code')) {
    function get_currency_code()
    {
        $currency = Currency::where('tenant_id', getTenantId())->where('current_currency', STATUS_ACTIVE)->first();
        if ($currency) {
            $currency_code = $currency->currency_code;
            return $currency_code;
        }

        return '';
    }
}

if (!function_exists('get_currency_placement')) {
    function get_currency_placement()
    {
        $currency = Currency::where('tenant_id', getTenantId())->where('current_currency', STATUS_ACTIVE)->first();
        $placement = 'before';
        if ($currency) {
            $placement = $currency->currency_placement;
            return $placement;
        }

        return $placement;
    }
}

if (!function_exists('customNumberFormat')) {
    function customNumberFormat($value)
    {
        $number = explode('.', $value);
        if (!isset($number[1])) {
            return number_format($value, 8, '.', '');
        } else {
            $result = substr($number[1], 0, 8);
            if (strlen($result) < 8) {
                $result = number_format($value, 8, '.', '');
            } else {
                $result = $number[0] . "." . $result;
            }

            return $result;
        }
    }
}

 function humanFileSize($size, $unit = '')
{
    if ((!$unit && $size >= 1 << 30) || $unit == 'GB') {
        return number_format($size / (1 << 30), 2) . 'GB';
    }

    if ((!$unit && $size >= 1 << 20) || $unit == 'MB') {
        return number_format($size / (1 << 20), 2) . 'MB';
    }

    if ((!$unit && $size >= 1 << 10) || $unit == 'KB') {
        return number_format($size / (1 << 10), 2) . 'KB';
    }

    return number_format($size) . ' bytes';
}

if (!function_exists('getMeta')) {
    function getMeta($slug)
    {
        $metaData = [
            'meta_title' => null,
            'meta_description' => null,
            'meta_keyword' => null,
            'og_image' => null,
        ];

        $meta = Meta::where('slug', $slug)->select([
            'meta_title',
            'meta_description',
            'meta_keyword',
            'og_image',
        ])->first();

        if(!is_null($meta)){
                $metaData = $meta->toArray();
        }else{
            $meta = Meta::where('slug', 'default')->select([
                'meta_title',
                'meta_description',
                'meta_keyword',
                'og_image',
            ])->first();

            if(!is_null($meta)){
                $metaData = $meta->toArray();
            }
        }

        $metaData['meta_title'] = $metaData['meta_title'] != NULL ? $metaData['meta_title'] : getOption('app_name');
        $metaData['meta_description'] = $metaData['meta_description'] != NULL ? $metaData['meta_description'] : getOption('app_name');
        $metaData['meta_keyword'] = $metaData['meta_keyword'] != NULL ? $metaData['meta_keyword'] : getOption('app_name');
        $metaData['og_image'] = $metaData['og_image'] != NULL ? getFileUrl($metaData['og_image']) : getFileUrl(getOption('app_logo'));

        return $metaData;
    }
}

function genericEmailNotify($singleData=NULL,$userData=NULL,$customData=NULL,$template=NULL,$link=NULL)
{
    if(getOption('app_mail_status')==STATUS_ACTIVE)
    {
        try {
            if ($singleData != NULL && $singleData != "") {
                Mail::to($singleData->to)->send(new EmailNotify($singleData, $userData, $customData, $template, $link));
            } elseif ($userData != NULL && $userData != "") {
                Mail::to($userData->email)->send(new EmailNotify($singleData, $userData, $customData, $template, $link));
            }
            return ['success' => true];
        }catch (Exception $e){
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }

    return ['success' => false, 'message' => __('Please enable the E-mail credentials status')];
}

function genericEmailNotifyTemplate($id,$emails)
{
    if (getOption('app_mail_status') == STATUS_ACTIVE) {
        try {
            $to = $emails[0];
            unset($emails[0]);
            $template = SubscriptionEmailTemplate::where('tenant_id', getTenantId())->where('id', $id)->first();
            Mail::to($to)->bcc($emails)->send(new SubscriptionEmail($template));

            return ['success' => true];
        } catch (Exception $e) {
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }

    return ['success' => false, 'message' => __('Please enable the E-mail credentials status')];
}

function getEmailTemplate($category, $property, $link = NULL, $customData = NULL, $userData = NULL)
{
    $data = EmailTemplate::where('tenant_id', getTenantId())->where('slug', $category)->first();
    if ($data && $data != NULL) {
        if ($property == 'body') {
            $body = $data->{$property};
            foreach (emailTempFields() as $key => $item) {
                if ($key == '{{link}}') {
                    $body = str_replace($key, $link, $body);
                } elseif ($key == '{{transaction_no}}' && $customData != NULL && isset($customData['transaction_no'])) {
                    $body = str_replace($key, is_object($customData)?$customData->transaction_no:$customData['transaction_no'], $body);
                } elseif ($key == '{{ticket_number}}' && $customData != NULL && isset($customData['ticket_number'])) {
                    $body = str_replace($key, is_object($customData)?$customData->ticket_number:$customData['ticket_number'], $body);
                } elseif ($key == '{{username}}') {
                    $body = str_replace($key, $userData->name, $body);
                } elseif ($key == '{{app_contact_number}}' && !empty(getOption('app_contact_number'))) {
                    $body = str_replace($key, getOption('app_contact_number'), $body);
                } elseif ($key == '{{app_email}}' && !empty(getOption('app_email'))) {
                    $body = str_replace($key, getOption('app_email'), $body);
                } elseif ($key == '{{app_name}}' && !empty(getOption('app_name'))) {
                    $body = str_replace($key, getOption('app_name'), $body);
                } elseif ($key == '{{otp}}') {
                    $body = str_replace($key, $userData->otp, $body);
                } else {
                    $body = str_replace($key, $item, $body);
                }
            }
            return $body;
        } elseif ($property == 'subject') {

            $subject = $data->{$property};
            foreach (emailTempFields() as $key => $item) {
                if ($key == '{{customField}}') {
                    $subject = str_replace($key, $customData->customField, $subject);
                }
            }
            return $subject;
        } else {
            return $data->{$property};
        }
    }
    return '';
}

if (!function_exists('setCommonNotification')) {
    function setCommonNotification($title, $details, $link = NULL, $userId = NULL)
    {
        try {
            DB::beginTransaction();
            $obj = new Notification();
            $obj->user_id = $userId != NULL ? $userId : NULL;
            $obj->title = $title;
            $obj->body = $details;
            $obj->link = $link != NULL ? $link : NULL;
            $obj->tenant_id = getTenantId();
            $obj->save();
            DB::commit();
            return true;
        } catch (Exception $e) {
            DB::rollBack();
            return false;
        }
    }
}

if (!function_exists('userNotification')) {
    function userNotification($type)
    {
        if ($type == 'seen') {
            return Notification::leftJoin('notification_seens', 'notifications.id', '=', 'notification_seens.notification_id')
                ->where(function ($query) {
                    $query->where('notifications.user_id', null)->orWhere('notifications.user_id', Auth::id());
                })
                ->where('notifications.status', ACTIVE)
                ->where('notification_seens.id', '!=', null)
                ->orderBy('id', 'DESC')
                ->get([
                    'notifications.*',
                    'notification_seens.id as seen_id',
                ]);
        } else if ($type == 'unseen') {
            return Notification::leftJoin('notification_seens', 'notifications.id', '=', 'notification_seens.notification_id')
                ->where(function ($query) {
                    $query->where('notifications.user_id', null)->orWhere('notifications.user_id', Auth::id());
                })
                ->where('notifications.status', ACTIVE)
                ->where('notification_seens.id', null)
                ->orderBy('id', 'DESC')
                ->get([
                    'notifications.*',
                    'notification_seens.id as seen_id',
                ]);

        } else if ($type == 'seen-unseen') {
            return Notification::leftJoin('notification_seens', 'notifications.id', '=', 'notification_seens.notification_id')
                ->where(function ($query) {
                    $query->where('notifications.user_id', null)->orWhere('notifications.user_id', Auth::id());
                })
                ->where('notifications.status', ACTIVE)
                ->orderBy('id', 'DESC')
                ->get([
                    'notifications.*',
                    'notification_seens.id as seen_id',
                ]);
        }

    }
}

if (!function_exists('getSubText')) {
    function getSubText($html, $limit= 100000)
    {
        return \Illuminate\Support\Str::limit(strip_tags($html), $limit);
    }
}
if (!function_exists('getPaymentType')) {
    function getPaymentType($object)
    {
        return $className = class_basename(get_class($object));
    }
}
if (!function_exists('thousandFormat')) {
    function thousandFormat($number) {
        $number = (int) preg_replace('/[^0-9]/', '', $number);
        if ($number >= 1000) {
            $rn = round($number);
            $format_number = number_format($rn);
            $ar_nbr = explode(',', $format_number);
            $x_parts = array('K', 'M', 'B', 'T', 'Q');
            $x_count_parts = count($ar_nbr) - 1;
            $dn = $ar_nbr[0] . ((int) $ar_nbr[1][0] !== 0 ? '.' . $ar_nbr[1][0] : '');
            $dn .= $x_parts[$x_count_parts - 1];

            return $dn;
        }
        return $number;
    }
}

if (!function_exists('getTicketNumber')) {
    function getTicketNumber($eventId, $oldTotal) {
        return $eventId.sprintf('%04d', ++$oldTotal);
    }
}

if (!function_exists('userMessageUnseen')) {
    function userMessageUnseen() {
        return Chat::where('chats.tenant_id', getTenantId())->where('receiver_id', auth()->id())->where('is_seen', STATUS_PENDING)->count();
    }
}

if (!function_exists('isOnline')) {
    function isOnline($last_seen) {
        return Carbon::parse($last_seen)->gte(now());
    }
}

if (!function_exists('isCentralDomain')) {
    function isCentralDomain() {
        $central_domains = Config::get('tenancy.central_domains')[0];
        return getHostFromURL($central_domains) == getHostFromURL(request()->getHost());
    }
}

if (!function_exists('centralDomain')) {
    function centralDomain() {
        return Config::get('tenancy.central_domains')[0];

    }
}

if (!function_exists('gatewaySettings')) {
    function gatewaySettings()
    {
        return '{
        "paypal":[{"label":"Url","name":"url","is_show":0},{"label":"Client ID","name":"key","is_show":1},{"label":"Secret","name":"secret","is_show":1}],
        "stripe":[{"label":"Url","name":"url","is_show":0},{"label":"Public Key","name":"key","is_show":1},{"label":"Secret Key","name":"secret","is_show":0}],
        "razorpay":[{"label":"Url","name":"url","is_show":0},{"label":"Key","name":"key","is_show":1},{"label":"Secret","name":"secret","is_show":1}],
        "instamojo":[{"label":"Url","name":"url","is_show":0},{"label":"Api Key","name":"key","is_show":1},{"label":"Auth Token","name":"secret","is_show":1}],
        "mollie":[{"label":"Url","name":"url","is_show":0},{"label":"Mollie Key","name":"key","is_show":1},{"label":"Secret","name":"secret","is_show":0}],
        "paystack":[{"label":"Url","name":"url","is_show":0},{"label":"Public Key","name":"key","is_show":1},{"label":"Secret Key","name":"secret","is_show":0}],
        "mercadopago":[{"label":"Url","name":"url","is_show":0},{"label":"Client ID","name":"key","is_show":1},{"label":"Client Secret","name":"secret","is_show":1}],
        "sslcommerz":[{"label":"Url","name":"url","is_show":0},{"label":"Store ID","name":"key","is_show":1},{"label":"Store Password","name":"secret","is_show":1}],
        "flutterwave":[{"label":"Hash","name":"url","is_show":1},{"label":"Public Key","name":"key","is_show":1},{"label":"Client Secret","name":"secret","is_show":1}],
        "coinbase":[{"label":"Hash","name":"url","is_show":0},{"label":"API Key","name":"key","is_show":1},{"label":"Client Secret","name":"secret","is_show":0}],
        "binance":[{"label":"Url","name":"url","is_show":0},{"label":"Client ID","name":"key","is_show":1},{"label":"Client Secret","name":"secret","is_show":1}],
        "bitpay":[{"label":"Url","name":"url","is_show":0},{"label":"Key","name":"key","is_show":1},{"label":"Client Secret","name":"secret","is_show":0}],
        "iyzico":[{"label":"Url","name":"url","is_show":0},{"label":"Key","name":"key","is_show":1},{"label":"Secret","name":"secret","is_show":1}],
        "payhere":[{"label":"Url","name":"url","is_show":0},{"label":"Merchant ID","name":"key","is_show":1},{"label":"Merchant Secret","name":"secret","is_show":1}],
        "maxicash":[{"label":"Url","name":"url","is_show":0},{"label":"Merchant ID","name":"key","is_show":1},{"label":"Password","name":"secret","is_show":1}],
        "paytm":[{"label":"Industry Type","name":"url","is_show":1},{"label":"Merchant Key","name":"key","is_show":1},{"label":"Merchant ID","name":"secret","is_show":1}],
        "zitopay":[{"label":"Industry Type","name":"url","is_show":0},{"label":"Key","name":"key","is_show":1},{"label":"Merchant ID","name":"secret","is_show":0}],
        "cinetpay":[{"label":"Industry Type","name":"url","is_show":0},{"label":"API Key","name":"key","is_show":1},{"label":"Site ID","name":"secret","is_show":1}],
        "voguepay":[{"label":"Industry Type","name":"url","is_show":0},{"label":"Merchant ID","name":"key","is_show":1},{"label":"Merchant ID","name":"secret","is_show":0}],
        "toyyibpay":[{"label":"Industry Type","name":"url","is_show":0},{"label":"Secret Key","name":"key","is_show":1},{"label":"Category Code","name":"secret","is_show":1}],
        "paymob":[{"label":"Industry Type","name":"url","is_show":0},{"label":"API Key","name":"key","is_show":1},{"label":"Integration ID","name":"secret","is_show":1}],
        "alipay":[{"label":"APP ID","name":"url","is_show":1},{"label":"Public Key","name":"key","is_show":1},{"label":"Private Key","name":"secret","is_show":1}],
        "authorize":[{"label":"Industry Type","name":"url","is_show":0},{"label":"Login ID","name":"key","is_show":1},{"label":"Transaction Key","name":"secret","is_show":1}]
        }';
    }
}

if (!function_exists('generateRandomString')) {
    function generateRandomString($length = 8)
    {
        $characters = 'abcdefghijklmnopqrstuvwxyz';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[random_int(0, $charactersLength - 1)];
        }
        return $randomString;
    }
}

if (!function_exists('copyFolder')) {
    function copyFolder($source, $destination)
    {
        if (is_dir($source)) {
            if (!is_dir($destination)) {
                mkdir($destination, 0755, true); // Create the destination directory if it doesn't exist
            }

            $dir = opendir($source);

            while (false !== ($file = readdir($dir))) {
                if (($file != '.') && ($file != '..')) {
                    $src = $source . '/' . $file;
                    $dest = $destination . '/' . $file;

                    if (is_dir($src)) {
                        // If it's a directory, recursively call the function
                        copyFolder($src, $dest);
                    } else {
                        // If it's a file, use copy() to copy it
                        copy($src, $dest);
                    }
                }
            }

            closedir($dir);
        } else {
            // If the source is a file, use copy() to copy it
            copy($source, $destination);
        }
    }
}

if (!function_exists('userCurrentPackage')) {
    function userCurrentPackage($tenantId)
    {
        return UserPackage::query()
            ->where('status', ACTIVE)
            ->where('tenant_id', $tenantId)
            ->where('end_date', '>=', now())->with('package')
            ->first();
    }
}

function getTenantId()
{
    if (isCentralDomain()) {
        if(isAddonInstalled('ALUSAAS')){
            return auth()->user()?->tenant_id;
        }else{
            return \Stancl\Tenancy\Database\Models\Domain::first()->tenant_id;
        }
    }else{
        if(isAddonInstalled('ALUSAAS')){
            return tenant('id');
        }else{
            return \Stancl\Tenancy\Database\Models\Domain::first()->tenant_id;
        }
    }
}


function getPackageLimit($rule){
    $userPackage = userCurrentPackage(getTenantId());
    if($rule == PACKAGE_RULE_EXPIRED) {
        return is_null($userPackage) && isAddonInstalled('ALUSAAS') ? true : false;
    }else if($rule == PACKAGE_RULE_CUSTOM_DOMAIN){
        return !is_null($userPackage) && $userPackage->package->custom_domain && isAddonInstalled('ALUSAAS') == STATUS_ACTIVE;
    }else {
        if ($rule == PACKAGE_RULE_ALUMNI_LIMIT) {
            $alumniCount = \App\Models\Alumni::where('tenant_id', getTenantId())->count();
            if (!is_null($userPackage) && $userPackage->package->alumni_limit == -1){
                return -1;
            }
            return !is_null($userPackage) ? $userPackage->package->alumni_limit - $alumniCount : 0;
        } else if ($rule == PACKAGE_RULE_EVENT_LIMIT) {
            $eventCount = \App\Models\Event::where('tenant_id', getTenantId())->count();
            if (!is_null($userPackage) && $userPackage->package->event_limit == -1){
                return -1;
            }
            return !is_null($userPackage) ? $userPackage->package->event_limit - $eventCount : 0;
        }
    }
}

if (!function_exists('addLeadingZero')) {
    function addLeadingZero($number) {
        return str_pad($number, 2, '0', STR_PAD_LEFT);
    }
}
if (!function_exists('getHostFromURL')) {
    function getHostFromURL($url)
    {
        // Remove scheme (http://, https://) from the URL
        $url = preg_replace('#^https?://#', '', $url);

        // Remove www. if present
        $url = preg_replace('#^www\.#', '', $url);

        // Extract the domain name
        $parts = explode('/', $url);
        $domain = array_shift($parts);

        return $domain;
    }
}

if (!function_exists('syncMissingGateway')) {
    function syncMissingGateway(): void
    {
        $tenants = \App\Models\Tenant::all();
        $gateways = getPaymentServiceClass(); // Get all the available gateways

        // Loop through each tenant
        foreach ($tenants as $tenant) {
            // Get all existing gateways for the current tenant
            $existingGateways = \App\Models\Gateway::where('tenant_id', $tenant->id)->pluck('slug')->toArray();

            // Loop through each gateway in the payment services list
            foreach ($gateways as $gatewaySlug => $gatewayService) {
                // If the gateway doesn't exist for the tenant, insert it
                if (!in_array($gatewaySlug, $existingGateways)) {
                    // Insert missing gateway for the tenant
                    $gateway = new \App\Models\Gateway();
                    $gateway->tenant_id = $tenant->id;
                    $gateway->title = ucfirst($gatewaySlug);
                    $gateway->slug = $gatewaySlug;
                    $gateway->image = 'assets/images/gateway-icon/' . $gatewaySlug . '.png';
                    $gateway->status = 1;
                    $gateway->mode = 2; // Assuming '2' is the default mode
                    $gateway->created_at = now();
                    $gateway->updated_at = now();
                    $gateway->save();

                    // Insert currency for the new gateway
                    $currency = new \App\Models\GatewayCurrency();
                    $currency->gateway_id = $gateway->id;
                    $currency->currency = 'USD';
                    $currency->conversion_rate = 1.0;
                    $currency->created_at = now();
                    $currency->updated_at = now();
                    $currency->save();
                }
            }
        }

        // Now handle tenant_id = null (global gateways)
        $existingGatewaysForNullTenant = \App\Models\Gateway::whereNull('tenant_id')->pluck('slug')->toArray();

        foreach ($gateways as $gatewaySlug => $gatewayService) {
            // If the gateway doesn't exist for tenant_id = null, insert it
            if (!in_array($gatewaySlug, $existingGatewaysForNullTenant)) {
                // Insert missing gateway for tenant_id = null
                $gateway = new \App\Models\Gateway();
                $gateway->tenant_id = null;
                $gateway->title = ucfirst($gatewaySlug);
                $gateway->slug = $gatewaySlug;
                $gateway->image = 'assets/images/gateway-icon/' . $gatewaySlug . '.png';
                $gateway->status = 1;
                $gateway->mode = 2;
                $gateway->created_at = now();
                $gateway->updated_at = now();
                $gateway->save();

                // Insert currency for the new gateway (tenant_id = null)
                $currency = new \App\Models\GatewayCurrency();
                $currency->gateway_id = $gateway->id;
                $currency->currency = 'USD';
                $currency->conversion_rate = 1.0;
                $currency->created_at = now();
                $currency->updated_at = now();
                $currency->save();
            }
        }
    }
}
