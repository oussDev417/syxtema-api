<?php

namespace App\Http\Controllers\Frontend;

use App\Models\User;
use App\Models\Course;
use App\Mail\DefaultMail;
use Illuminate\View\View;
use App\Jobs\DefaultMailJob;
use Illuminate\Http\Request;
use App\Models\UserEducation;
use App\Models\UserExperience;
use App\Rules\CustomRecaptcha;
use App\Traits\MailSenderTrait;
use Modules\Faq\app\Models\Faq;
use Illuminate\Http\JsonResponse;
use Modules\Blog\app\Models\Blog;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\App;
use Modules\Brand\app\Models\Brand;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Modules\Badges\app\Models\Badge;
use Illuminate\Support\Facades\Cache;
use Modules\Location\app\Models\City;
use Modules\Location\app\Models\State;
use Illuminate\Support\Facades\Session;
use Modules\Location\app\Models\Country;
use Modules\Frontend\app\Models\FaqSection;
use Modules\Frontend\app\Models\HeroSection;
use Modules\Course\app\Models\CourseCategory;
use Modules\Frontend\app\Models\AboutSection;
use Modules\Frontend\app\Models\BannerSection;
use Modules\PageBuilder\app\Models\CustomPage;
use Modules\Frontend\app\Models\CounterSection;
use Modules\Testimonial\app\Models\Testimonial;
use Modules\Frontend\app\Models\NewsletterSection;
use Modules\Frontend\app\Models\FeaturedInstructor;
use Modules\Frontend\app\Models\OurFeaturesSection;
use Modules\GlobalSetting\app\Models\EmailTemplate;
use Modules\SiteAppearance\app\Models\SectionSetting;
use Modules\Frontend\app\Models\FeaturedCourseSection;

class HomePageController extends Controller {
    use MailSenderTrait;

    function index(): View {
        $trendingCategories = CourseCategory::with(['translation:id,name,course_category_id', 'subCategories' => function ($query) {
            $query->withCount(['courses' => function ($query) {
                $query->where('status', 'active');
            }]);
        }])->withCount(['subCategories as active_sub_categories_count' => function ($query) {
            $query->whereHas('courses', function ($query) {
                $query->where('status', 'active');
            });
        }])->whereNull('parent_id')
            ->where('status', 1)
            ->where('show_at_trending', 1)
            ->get();
    
        $instructorIds = json_decode($featuredInstructorSection->instructor_ids ?? '[]');

        $selectedInstructors = User::whereIn('id', $instructorIds)
            ->with(['courses' => function ($query) {
                $query->withCount(['reviews as avg_rating' => function ($query) {
                    $query->select(DB::raw('coalesce(avg(rating),0)'));
                }]);
            }])
            ->get();

        

        $siteTheme = Session::has('demo_theme') ? Session::get('demo_theme') : Cache::get('setting')?->site_theme;
        if ($siteTheme == 'theme-two') {
            $themePath = 'frontend.home-two.index';
        } elseif ($siteTheme == 'theme-three') {
            $themePath = 'frontend.home-three.index';
        }elseif ($siteTheme == 'theme-four') {
            $themePath = 'frontend.home-four.index';
        } else {
            $themePath = 'frontend.pages.course';
        }
        return view($themePath, compact(
            'trendingCategories',
            'selectedInstructors',
        ));
    }

    function countries(): JsonResponse {
        $countries = Country::where('status', 1)->get();
        return response()->json($countries);
    }

    function states(string $id): JsonResponse {
        $states = State::where(['country_id' => $id, 'status' => 1])->get();
        return response()->json($states);
    }

    function cities(string $id): JsonResponse {
        $cities = City::where(['state_id' => $id, 'status' => 1])->get();
        return response()->json($cities);
    }

    public function setCurrency() {
        $currency = allCurrencies()->where('currency_code', request('currency'))->first();
        if (session()->has('currency_code')) {
            session()->forget('currency_code');
            session()->forget('currency_position');
            session()->forget('currency_icon');
            session()->forget('currency_rate');
        }
        if ($currency) {
            session()->put('currency_code', $currency->currency_code);
            session()->put('currency_position', $currency->currency_position);
            session()->put('currency_icon', $currency->currency_icon);
            session()->put('currency_rate', $currency->currency_rate);

            $notification = __('Currency Changed Successfully');
            $notification = ['messege' => $notification, 'alert-type' => 'success'];

            return redirect()->back()->with($notification);
        }
        getSessionCurrency();
        $notification = __('Currency Changed Successfully');
        $notification = ['messege' => $notification, 'alert-type' => 'success'];

        return redirect()->back()->with($notification);
    }

    function instructorDetails(string $id) {
        User::where(['status' => 'active', 'is_banned' => 0, 'id' => $id])->first();
        $instructor = User::where(['status' => 'active', 'is_banned' => 0, 'id' => $id])->with(['courses' => function ($query) {
            $query->withCount(['reviews as avg_rating' => function ($query) {
                $query->select(DB::raw('coalesce(avg(rating),0)'));
            }]);
        }])
            ->firstOrFail();
        $experiences = UserExperience::where(['user_id' => $id])->get();
        $educations = UserEducation::where(['user_id' => $id])->get();
        $courses = Course::active()->where(['instructor_id' => $id])->orderBy('id', 'desc')->get();
        $badges = Badge::where(['status' => 1])->get()->groupBy('key');
        return view('frontend.pages.instructor-details', compact('instructor', 'experiences', 'educations', 'courses', 'badges'));
    }

    function allInstructors() {
        $instructors = User::where(['status' => 'active', 'is_banned' => 0, 'role' => 'instructor'])
            ->withCount('courses as course_count')
            ->with(['courses' => function ($query) {
                $query->withCount(['reviews as avg_rating' => function ($query) {
                    $query->select(DB::raw('coalesce(avg(rating),0)'));
                }]);
            }])
            ->orderByDesc('course_count')
            ->paginate(18);

        return view('frontend.pages.all-instructors', compact('instructors'));
    }

    function quickConnect(Request $request, string $id) {
        $validated = $request->validate([
            'name'                 => ['required', 'string', 'max:255'],
            'email'                => ['required', 'string', 'email', 'max:255'],
            'subject'              => ['required', 'string', 'max:255'],
            'message'              => ['required', 'string', 'max:1000'],
            'g-recaptcha-response' => Cache::get('setting')->recaptcha_status == 'active' ? ['required', new CustomRecaptcha()] : 'nullable',
        ]);

        $settings = cache()->get('setting');
        $marketingSettings = cache()->get('marketing_setting');
        if ($settings->google_tagmanager_status == 'active' && $marketingSettings->instructor_contact) {
            $instructor_contact = [
                'name'    => $request->name,
                'email'   => $request->email,
                'subject' => $request->subject,
                'message' => $request->message,
            ];
            session()->put('instructorQuickContact', $instructor_contact);
        }

        $this->handleMailSending($validated);
        return redirect()->back()->with(['messege' => __('Message sent successfully'), 'alert-type' => 'success']);
    }

    function handleMailSending(array $mailData) {
        self::setMailConfig();

        // Get email template
        $template = EmailTemplate::where('name', 'instructor_quick_contact')->firstOrFail();

        // Prepare email content
        $message = str_replace('{{name}}', $mailData['name'], $template->message);
        $message = str_replace('{{email}}', $mailData['email'], $message);
        $message = str_replace('{{subject}}', $mailData['subject'], $message);
        $message = str_replace('{{message}}', $mailData['message'], $message);

        if (self::isQueable()) {
            DefaultMailJob::dispatch($mailData['email'], $mailData, $message);
        } else {
            Mail::to($mailData['email'])->send(new DefaultMail($mailData, $message));
        }
    }

    function customPage(string $slug) {
        $page = CustomPage::where('slug', $slug)->firstOrFail();
        return view('frontend.pages.custom-page', compact('page'));
    }

    function changeTheme(string $theme) {
        if (Cache::get('setting')?->show_all_homepage != 1) {
            abort(404);
        }

        if ($theme == 'theme-one') {
            Session::put('demo_theme', 'theme-one');
        } elseif ($theme == 'theme-two') {
            Session::put('demo_theme', 'theme-two');
        } elseif ($theme == 'theme-three') {
            Session::put('demo_theme', 'theme-three');
        }elseif ($theme == 'theme-four') {
            Session::put('demo_theme', 'theme-four');
        }

        return redirect('/');
    }
}
