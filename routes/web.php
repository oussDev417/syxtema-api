<?php

use App\Http\Controllers\Admin\NewController;
use App\Http\Controllers\Admin\PartnerController;
use App\Http\Controllers\Admin\StartupController;
use App\Http\Controllers\Admin\SuccessStoryController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\EventController;
use App\Http\Controllers\Admin\EventCategoryController;
use App\Http\Controllers\Admin\CountryController;
use App\Http\Controllers\Admin\DepartementController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\ServiceCategoryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Frontend\AboutPageController;
use App\Http\Controllers\Frontend\BecomeInstructorController;
use App\Http\Controllers\Frontend\BlogController;
use App\Http\Controllers\Frontend\CartController;
use App\Http\Controllers\Frontend\CheckOutController;
use App\Http\Controllers\Frontend\ContactController;
use App\Http\Controllers\Frontend\CourseContentController;
use App\Http\Controllers\Frontend\CoursePageController;
use App\Http\Controllers\Frontend\HomePageController;
use App\Http\Controllers\Frontend\InstructorAnnouncementController;
use App\Http\Controllers\Frontend\InstructorCourseController;
use App\Http\Controllers\Frontend\InstructorDashboardController;
use App\Http\Controllers\Frontend\InstructorLessonQnaController;
use App\Http\Controllers\Frontend\InstructorLiveCredentialController;
use App\Http\Controllers\Frontend\InstructorPayoutController;
use App\Http\Controllers\Frontend\InstructorProfileSettingController;
use App\Http\Controllers\Frontend\LearningController;
use App\Http\Controllers\Frontend\PaymentController;
use App\Http\Controllers\Frontend\QnaController;
use App\Http\Controllers\Frontend\StudentDashboardController;
use App\Http\Controllers\Frontend\StudentOrderController;
use App\Http\Controllers\Frontend\StudentProfileSettingController;
use App\Http\Controllers\Frontend\StudentReviewController;
use App\Http\Controllers\Frontend\TinymceImageUploadController;
use App\Http\Controllers\Global\CloudStorageController;
use App\Http\Controllers\Admin\TeamController;
use App\Http\Controllers\Admin\TestimonialController;
use App\Http\Controllers\Admin\PortfolioController;

Route::get('/', function () {
    return view('welcome');
});

Route::view('index', 'index')->name('index');
Route::view('project_dashboard', 'project_dashboard')->name('project_dashboard');
Route::view('education_dashboard', 'education_dashboard')->name('education_dashboard');

// Route::view('admin_dashboard', 'admin.dashboard')->name('admin.dashboard');
Route::view('accordions', 'accordions')->name('accordions');
Route::view('add_blog', 'add_blog')->name('add_blog');
Route::view('add_product', 'add_product')->name('add_product');
Route::view('advance_table', 'advance_table')->name('advance_table');
Route::view('alert', 'alert')->name('alert');
Route::view('alignment', 'alignment')->name('alignment');
Route::view('animated_icon', 'animated_icon')->name('animated_icon');
Route::view('animation', 'animation')->name('animation');
Route::view('api', 'api')->name('api');
Route::view('area_chart', 'area_chart')->name('area_chart');
Route::view('avatar', 'avatar')->name('avatar');

Route::view('background', 'background')->name('background');
Route::view('badges', 'badges')->name('badges');
Route::view('bar_chart', 'bar_chart')->name('bar_chart');
Route::view('base_inputs', 'base_inputs')->name('base_inputs');
Route::view('basic_table', 'basic_table')->name('basic_table');
Route::view('blank', 'blank')->name('blank');
Route::view('block_ui', 'block_ui')->name('block_ui');
Route::view('blog', 'blog')->name('blog');
Route::view('blog_details', 'blog_details')->name('blog_details');
Route::view('bookmark', 'bookmark')->name('bookmark');
Route::view('bootstrap_slider', 'bootstrap_slider')->name('bootstrap_slider');
Route::view('boxplot_chart', 'boxplot_chart')->name('boxplot_chart');
Route::view('bubble_chart', 'bubble_chart')->name('bubble_chart');
Route::view('bullet', 'bullet')->name('bullet');
Route::view('buttons', 'buttons')->name('buttons');

Route::view('calendar', 'calendar')->name('calendar');
Route::view('candlestick_chart', 'candlestick_chart')->name('candlestick_chart');
Route::view('cards', 'cards')->name('cards');
Route::view('cart', 'cart')->name('cart');
Route::view('chart_js', 'chart_js')->name('chart_js');
Route::view('chat', 'chat')->name('chat');
Route::view('cheatsheet', 'cheatsheet')->name('cheatsheet');
Route::view('checkbox_radio', 'checkbox_radio')->name('checkbox_radio');
Route::view('checkout', 'checkout')->name('checkout');
Route::view('clipboard', 'clipboard')->name('clipboard');
Route::view('collapse', 'collapse')->name('collapse');
Route::view('column_chart', 'column_chart')->name('column_chart');
Route::view('coming_soon', 'coming_soon')->name('coming_soon');
Route::view('count_down', 'count_down')->name('count_down');
Route::view('count_up', 'count_up')->name('count_up');

Route::view('data_table', 'data_table')->name('data_table');
Route::view('date_picker', 'date_picker')->name('date_picker');
Route::view('default_forms', 'default_forms')->name('default_forms');
Route::view('divider', 'divider')->name('divider');
Route::view('draggable', 'draggable')->name('draggable');
Route::view('dropdown', 'dropdown')->name('dropdown');
Route::view('dual_list_boxes', 'dual_list_boxes')->name('dual_list_boxes');

Route::view('editor', 'editor')->name('editor');
Route::view('email', 'email')->name('email');
Route::view('error_400', 'error_400')->name('error_400');
Route::view('error_403', 'error_403')->name('error_403');
Route::view('error_404', 'error_404')->name('error_404');
Route::view('error_500', 'error_500')->name('error_500');
Route::view('error_503', 'error_503')->name('error_503');

Route::view('faq', 'faq')->name('faq');
Route::view('file_manager', 'file_manager')->name('file_manager');
Route::view('file_upload', 'file_upload')->name('file_upload');
Route::view('flag_icons', 'flag_icons')->name('flag_icons');
Route::view('floating_labels', 'floating_labels')->name('floating_labels');
Route::view('fontawesome', 'fontawesome')->name('fontawesome');
Route::view('footer_page', 'footer_page')->name('footer_page');
Route::view('form_validation', 'form_validation')->name('form_validation');
Route::view('form_wizard_1', 'form_wizard_1')->name('form_wizard_1');
Route::view('form_wizard_2', 'form_wizard_2')->name('form_wizard_2');
Route::view('form_wizards', 'form_wizards')->name('form_wizards');

Route::view('gallery', 'gallery')->name('gallery');
Route::view('google_map', 'google_map')->name('google_map');
Route::view('grid', 'grid')->name('grid');

Route::view('heatmap', 'heatmap')->name('heatmap');
Route::view('helper_classes', 'helper_classes')->name('helper_classes');

Route::view('iconoir_icon', 'iconoir_icon')->name('iconoir_icon');
Route::view('input_groups', 'input_groups')->name('input_groups');
Route::view('input_masks', 'input_masks')->name('input_masks');
Route::view('invoice', 'invoice')->name('invoice');

Route::view('kanban_board', 'kanban_board')->name('kanban_board');

Route::view('landing', 'landing')->name('landing');
Route::view('leaflet_map', 'leaflet_map')->name('leaflet_map');
Route::view('line_chart', 'line_chart')->name('line_chart');
Route::view('list', 'list')->name('list');
Route::view('list_table', 'list_table')->name('list_table');
Route::view('lock_screen', 'lock_screen')->name('lock_screen');
Route::view('lock_screen_1', 'lock_screen_1')->name('lock_screen_1');


Route::view('maintenance', 'maintenance')->name('maintenance');
Route::view('misc', 'misc')->name('misc');
Route::view('mixed_chart', 'mixed_chart')->name('mixed_chart');
Route::view('modals', 'modals')->name('modals');
Route::view('notifications', 'notifications')->name('notifications');

Route::view('offcanvas', 'offcanvas')->name('offcanvas');
Route::view('orders', 'orders')->name('orders');
Route::view('order_details', 'order_details')->name('order_details');
Route::view('order_list', 'order_list')->name('order_list');

Route::view('password_create_1', 'password_create_1')->name('password_create_1');
Route::view('password_reset_1', 'password_reset_1')->name('password_reset_1');
Route::view('phosphor', 'phosphor')->name('phosphor');
Route::view('pie_charts', 'pie_charts')->name('pie_charts');
Route::view('placeholder', 'placeholder')->name('placeholder');
Route::view('pricing', 'pricing')->name('pricing');
Route::view('prismjs', 'prismjs')->name('prismjs');
Route::view('privacy_policy', 'privacy_policy')->name('privacy_policy');
Route::view('product', 'product')->name('product');
Route::view('product_details', 'product_details')->name('product_details');
Route::view('product_list', 'product_list')->name('product_list');
Route::view('profile', 'profile')->name('profile');
Route::view('progress', 'progress')->name('progress');
Route::view('project_app', 'project_app')->name('project_app');
Route::view('project_details', 'project_details')->name('project_details');
Route::view('password_create', 'password_create')->name('password_create');
Route::view('password_reset', 'password_reset')->name('password_reset');

Route::view('radar_chart', 'radar_chart')->name('radar_chart');
Route::view('radial_bar_chart', 'radial_bar_chart')->name('radial_bar_chart');
Route::view('range_slider', 'range_slider')->name('range_slider');
Route::view('ratings', 'ratings')->name('ratings');
Route::view('read_email', 'read_email')->name('read_email');
Route::view('ready_to_use_form', 'ready_to_use_form')->name('ready_to_use_form');
Route::view('ready_to_use_table', 'ready_to_use_table')->name('ready_to_use_table');
Route::view('ribbons', 'ribbons')->name('ribbons');

Route::view('scatter_chart', 'scatter_chart')->name('scatter_chart');
Route::view('scrollbar', 'scrollbar')->name('scrollbar');
Route::view('scrollpy', 'scrollpy')->name('scrollpy');
Route::view('select', 'select')->name('select');
Route::view('setting', 'setting')->name('setting');
Route::view('shadow', 'shadow')->name('shadow');
Route::view('sign_in', 'sign_in')->name('sign_in');
Route::view('sign_in_1', 'sign_in_1')->name('sign_in_1');
Route::view('sign_up', 'sign_up')->name('sign_up');
Route::view('sign_up_1', 'sign_up_1')->name('sign_up_1');
Route::view('sitemap', 'sitemap')->name('sitemap');
Route::view('slick_slider', 'slick_slider')->name('slick_slider');
Route::view('spinners', 'spinners')->name('spinners');
Route::view('sweetalert', 'sweetalert')->name('sweetalert');
Route::view('switch', 'switch')->name('switch');

Route::view('tabler_icons', 'tabler_icons')->name('tabler_icons');
Route::view('tabs', 'tabs')->name('tabs');
Route::view('team', 'team')->name('team');
Route::view('terms_condition', 'terms_condition')->name('terms_condition');
Route::view('textarea', 'textarea')->name('textarea');
Route::view('ticket', 'ticket')->name('ticket');
Route::view('ticket_details', 'ticket_details')->name('ticket_details');
Route::view('timeline', 'timeline')->name('timeline');
Route::view('timeline_range_charts', 'timeline_range_charts')->name('timeline_range_charts');
Route::view('to_do', 'to_do')->name('to_do');
Route::view('tooltips_popovers', 'tooltips_popovers')->name('tooltips_popovers');
Route::view('touch_spin', 'touch_spin')->name('touch_spin');
Route::view('tour', 'tour')->name('tour');
Route::view('tree-view', 'tree-view')->name('tree-view');
Route::view('treemap_chart', 'treemap_chart')->name('treemap_chart');
Route::view('two_step_verification', 'two_step_verification')->name('two_step_verification');
Route::view('two_step_verification_1', 'two_step_verification_1')->name('two_step_verification_1');
Route::view('typeahead', 'typeahead')->name('typeahead');

Route::view('vector_map', 'vector_map')->name('vector_map');
Route::view('video_embed', 'video_embed')->name('video_embed');
Route::view('weather_icon', 'weather_icon')->name('weather_icon');
Route::view('widget', 'widget')->name('widget');
Route::view('wishlist', 'wishlist')->name('wishlist');
Route::view('wrapper', 'wrapper')->name('wrapper');

// Routes pour les événements
Route::prefix('admin/events')->name('admin.events.')->group(function () {
    Route::get('/', [EventController::class, 'index'])->name('index'); // Afficher tous les événements
    Route::get('/create', [EventController::class, 'create'])->name('create'); // Formulaire pour créer un événement
    Route::post('/', [EventController::class, 'store'])->name('store'); // Enregistrer un nouvel événement
    Route::get('/{id}/edit', [EventController::class, 'edit'])->name('edit'); // Formulaire pour éditer un événement
    Route::put('/{id}', [EventController::class, 'update'])->name('update'); // Mettre à jour un événement
    Route::delete('/{id}', [EventController::class, 'destroy'])->name('destroy'); // Supprimer un événement
});

// Routes pour les actualités(news)
Route::prefix('admin/news')->name('admin.news.')->group(function () {
    Route::get('/', [NewController::class, 'index'])->name('index'); // Afficher toutes les actualités
    Route::get('/create', [NewController::class, 'create'])->name('create'); // Formulaire pour créer une nouvelle actualité
    Route::post('/', [NewController::class, 'store'])->name('store'); // Enregistrer une nouvelle actualité
    Route::get('/{id}/edit', [NewController::class, 'edit'])->name('edit'); // Formulaire pour éditer une actualité
    Route::put('/{id}', [NewController::class, 'update'])->name('update'); // Mettre à jour une actualité
    Route::delete('/{id}', [NewController::class, 'destroy'])->name('destroy'); // Supprimer une actualité
});

// Routes pour les catégories d'événements
Route::prefix('admin/event_categories')->name('admin.event_categories.')->group(function () {
    Route::get('/', [EventCategoryController::class, 'index'])->name('index'); // Afficher toutes les catégories
    Route::get('/create', [EventCategoryController::class, 'create'])->name('create'); // Formulaire pour créer une nouvelle catégorie
    Route::post('/', [EventCategoryController::class, 'store'])->name('store'); // Enregistrer une nouvelle catégorie
    Route::get('/{id}/edit', [EventCategoryController::class, 'edit'])->name('edit'); // Formulaire pour éditer un événement
    Route::put('/{id}', [EventCategoryController::class, 'update'])->name('update'); // Mettre à jour une catégorie
    Route::delete('/{id}', [EventCategoryController::class, 'destroy'])->name('destroy'); // Supprimer une catégorie
});

// Routes pour les pays
Route::prefix('admin/countries')->name('admin.countries.')->group(function () {
    Route::get('/', [CountryController::class, 'index'])->name('index');
    Route::get('/create', [CountryController::class, 'create'])->name('create');
    Route::post('/', [CountryController::class, 'store'])->name('store');
    Route::get('/{id}/edit', [CountryController::class, 'edit'])->name('edit');
    Route::put('/{id}', [CountryController::class, 'update'])->name('update');
    Route::delete('/{id}', [CountryController::class, 'destroy'])->name('destroy');
});

// Routes pour les départements
Route::prefix('admin/departements')->name('admin.departements.')->group(function () {
    Route::get('/', [DepartementController::class, 'index'])->name('index');
    Route::get('/create', [DepartementController::class, 'create'])->name('create');
    Route::post('/', [DepartementController::class, 'store'])->name('store');
    Route::get('/{id}/edit', [DepartementController::class, 'edit'])->name('edit');
    Route::put('/{id}', [DepartementController::class, 'update'])->name('update');
    Route::delete('/{id}', [DepartementController::class, 'destroy'])->name('destroy');
});

// Routes pour les services
Route::prefix('admin/services')->name('admin.services.')->group(function () {
    Route::get('/', [ServiceController::class, 'index'])->name('index');
    Route::get('/create', [ServiceController::class, 'create'])->name('create');
    Route::post('/', [ServiceController::class, 'store'])->name('store');
    Route::get('/{id}/edit', [ServiceController::class, 'edit'])->name('edit');
    Route::put('/{id}', [ServiceController::class, 'update'])->name('update');
    Route::delete('/{id}', [ServiceController::class, 'destroy'])->name('destroy');
});

// Routes pour les catégories de services
Route::prefix('admin/service_categories')->name('admin.service_categories.')->group(function () {
    Route::get('/', [ServiceCategoryController::class, 'index'])->name('index');
    Route::get('/create', [ServiceCategoryController::class, 'create'])->name('create');
    Route::post('/', [ServiceCategoryController::class, 'store'])->name('store');
    Route::get('/{id}/edit', [ServiceCategoryController::class, 'edit'])->name('edit');
    Route::put('/{id}', [ServiceCategoryController::class, 'update'])->name('update');
    Route::delete('/{id}', [ServiceCategoryController::class, 'destroy'])->name('destroy');
});

//maintenance mode route
Route::get('/maintenance-mode', function () {
    $setting = Illuminate\Support\Facades\Cache::get('setting', null);
    if (!$setting?->maintenance_mode) {
        return redirect()->route('home');
    }

    return view('global.maintenance');
})->name('maintenance.mode');

// require __DIR__ . '/auth.php';

// require __DIR__ . '/admin.php';

// Routes pour les témoignages
Route::prefix('admin/testimonials')->name('admin.testimonials.')->group(function () {
    Route::get('/', [TestimonialController::class, 'index'])->name('index'); // Afficher tous les témoignages
    Route::get('/create', [TestimonialController::class, 'create'])->name('create'); // Formulaire pour créer un témoignage
    Route::post('/', [TestimonialController::class, 'store'])->name('store'); // Enregistrer un nouveau témoignage
    Route::get('/{id}/edit', [TestimonialController::class, 'edit'])->name('edit'); // Formulaire pour éditer un témoignage
    Route::put('/{id}', [TestimonialController::class, 'update'])->name('update'); // Mettre à jour un témoignage
    Route::delete('/{id}', [TestimonialController::class, 'destroy'])->name('destroy'); // Supprimer un témoignage
});

// Routes pour les teams
Route::prefix('admin/teams')->name('admin.teams.')->group(function () {
    Route::get('/', [TeamController::class, 'index'])->name('index'); // Afficher tous les teams
    Route::get('/create', [TeamController::class, 'create'])->name('create'); // Formulaire pour créer un team
    Route::post('/', [TeamController::class, 'store'])->name('store'); // Enregistrer un nouveau team
    Route::get('/{id}/edit', [TeamController::class, 'edit'])->name('edit'); // Formulaire pour éditer un team
    Route::put('/{id}', [TeamController::class, 'update'])->name('update'); // Mettre à jour un team
    Route::delete('/{id}', [TeamController::class, 'destroy'])->name('destroy'); // Supprimer un team
});

// Routes pour les réalisations
Route::prefix('admin/portfolios')->name('admin.portfolios.')->group(function () {
    Route::get('/', [PortfolioController::class, 'index'])->name('index'); // Afficher toutes les réalisations
    Route::get('/create', [PortfolioController::class, 'create'])->name('create'); // Formulaire pour créer une réalisation
    Route::post('/', [PortfolioController::class, 'store'])->name('store'); // Enregistrer une nouvelle réalisation
    Route::get('/{id}/edit', [PortfolioController::class, 'edit'])->name('edit'); // Formulaire pour éditer une réalisation
    Route::put('/{id}', [PortfolioController::class, 'update'])->name('update'); // Mettre à jour une réalisation
    Route::delete('/{id}', [PortfolioController::class, 'destroy'])->name('destroy'); // Supprimer une réalisation
});

/**
 * ============================================================================
 * Global Routes
 * ============================================================================
 */

Route::get('set-language', [DashboardController::class, 'setLanguage'])->name('set-language');
Route::get('set-currency', [HomePageController::class, 'setCurrency'])->name('set-currency');

Route::get('/', [HomePageController::class, 'index'])->name('home');

Route::get('countries', [HomePageController::class, 'countries'])->name('countries');
Route::get('states/{country_id}', [HomePageController::class, 'states'])->name('states');
Route::get('cities/{state_id}', [HomePageController::class, 'cities'])->name('cities');

/** become a instructor */
Route::get('become-instructor', [BecomeInstructorController::class, 'index'])->name('become-instructor')->middleware('auth');
Route::post('become-instructor', [BecomeInstructorController::class, 'store'])->name('become-instructor.create')->middleware('auth');

Route::get('courses', [CoursePageController::class, 'index'])->name('courses');
Route::get('fetch-courses', [CoursePageController::class, 'fetchCourses'])->name('fetch-courses');
Route::get('course/{slug}', [CoursePageController::class, 'show'])->name('course.show');

/** cart routes */
Route::get('cart', [CartController::class, 'index'])->name('cart');
Route::post('add-to-cart/{id}', [CartController::class, 'addToCart'])->name('add-to-cart');
Route::get('remove-cart-item/{rowId}', [CartController::class, 'removeCartItem'])->name('remove-cart-item');
Route::post('apply-coupon', [CartController::class, 'applyCoupon'])->name('apply-coupon');
Route::get('remove-coupon', [CartController::class, 'removeCoupon'])->name('remove-coupon');

/** Blog Routes */
Route::get('all-instructors', [HomePageController::class, 'allInstructors'])->name('all-instructors');
Route::get('instructor-details/{id}/{slug?}', [HomePageController::class, 'instructorDetails'])->name('instructor-details');
Route::post('quick-connect/{id}', [HomePageController::class, 'quickConnect'])->name('quick-connect');

/** About page routes */
Route::get('about-us', [AboutPageController::class, 'index'])->name('about-us');
/** Contact page routes */
Route::get('contact', [ContactController::class, 'index'])->name('contact.index');
Route::post('contact/send-mail', [ContactController::class, 'sendMail'])->name('contact.send-mail');

/** Custom pages */
Route::get('page/{slug}', [HomePageController::class, 'customPage'])->name('custom-page');

/** other routes */
Route::group(['prefix' => 'laravel-filemanager', 'middleware' => ['auth:admin'], 'as' => 'admin.'], function () {
    \UniSharp\LaravelFilemanager\Lfm::routes();
});

Route::get('change-theme/{name}', [HomePageController::class, 'changeTheme'])->name('change-theme');

/**
 * ============================================================================
 * Student Dashboard Routes
 * ============================================================================
 */

Route::group(['middleware' => ['auth', 'verified'], 'prefix' => 'student', 'as' => 'student.'], function () {
    Route::get('dashboard', [StudentDashboardController::class, 'index'])->name('dashboard');
    // Profile setting routes
    Route::get('setting', [StudentProfileSettingController::class, 'index'])->name('setting.index');
    Route::put('setting/profile', [StudentProfileSettingController::class, 'updateProfile'])->name('setting.profile.update');
    Route::put('setting/bio', [StudentProfileSettingController::class, 'updateBio'])->name('setting.bio.update');
    Route::put('setting/password', [StudentProfileSettingController::class, 'updatePassword'])->name('setting.password.update');
    Route::get('setting/experience-modal', [StudentProfileSettingController::class, 'showExperienceModal'])->name('setting.experience-modal');
    Route::get('setting/edit-experience-modal/{id}', [StudentProfileSettingController::class, 'editExperienceModal'])->name('setting.edit-experience-modal');

    Route::post('setting/experience', [StudentProfileSettingController::class, 'storeExperience'])->name('setting.experience.store');
    Route::put('setting/experience/{id}', [StudentProfileSettingController::class, 'updateExperience'])->name('setting.experience.update');
    Route::delete('setting/experience/{id}', [StudentProfileSettingController::class, 'destroyExperience'])->name('setting.experience.destroy');

    Route::get('setting/add-education-modal', [StudentProfileSettingController::class, 'addEducationModal'])->name('setting.add-education-modal');
    Route::post('setting/education', [StudentProfileSettingController::class, 'storeEducation'])->name('setting.education.store');
    Route::get('setting/edit-education-modal/{id}', [StudentProfileSettingController::class, 'editEducationModal'])->name('setting.edit-education-modal');
    Route::put('setting/education/{id}', [StudentProfileSettingController::class, 'updateEducation'])->name('setting.education.update');
    Route::delete('setting/education/{id}', [StudentProfileSettingController::class, 'destroyEducation'])->name('setting.education.destroy');

    Route::put('setting/address', [StudentProfileSettingController::class, 'updateAddress'])->name('setting.address.update');
    Route::put('setting/socials', [StudentProfileSettingController::class, 'updateSocials'])->name('setting.socials.update');

    /** Order Routes */
    Route::get('orders', [StudentOrderController::class, 'index'])->name('orders.index');
    Route::get('order-details/{id}', [StudentOrderController::class, 'show'])->name('order.show');
    Route::get('order/invoice/{id}', [StudentOrderController::class, 'printInvoice'])->name('order.print-invoice');

    Route::get('reviews', [StudentReviewController::class, 'index'])->name('reviews.index');
    Route::get('reviews/{id}', [StudentReviewController::class, 'show'])->name('reviews.show');
    Route::delete('reviews/{id}', [StudentReviewController::class, 'destroy'])->name('reviews.destroy');
    Route::get('enrolled-courses', [StudentDashboardController::class, 'enrolledCourses'])->name('enrolled-courses');
    Route::get('quiz-attempts', [StudentDashboardController::class, 'quizAttempts'])->name('quiz-attempts');

    /** learning routes */
    Route::get('learning/{slug}', [LearningController::class, 'index'])->name('learning.index');
    Route::post('learning/get-file-info', [LearningController::class, 'getFileInfo'])->name('get-file-info');
    Route::post('learning/make-lesson-complete', [LearningController::class, 'makeLessonComplete'])->name('make-lesson-complete');
    Route::get('learning/resource-download/{id}', [LearningController::class, 'downloadResource'])->name('download-resource');

    Route::get('learning/quiz/{id}', [LearningController::class, 'quizIndex'])->name('quiz.index');
    Route::post('learning/quiz/{id}', [LearningController::class, 'quizStore'])->name('quiz.store');
    Route::get('learning/quiz-result/{id}/{result_id}', [LearningController::class, 'quizResult'])->name('quiz.result');
    Route::get('learning/{slug}/{lesson_id}', [LearningController::class, 'liveSession'])->name('learning.live');

    /** qna routes */
    Route::post('create-question', [QnaController::class, 'create'])->name('qna.create');
    Route::get('fetch-lesson-questions', [QnaController::class, 'fetchLessonQuestions'])->name('fetch-lesson-questions');
    Route::post('create-reply', [QnaController::class, 'createReply'])->name('create-reply');
    Route::get('fetch-replies', [QnaController::class, 'fetchReply'])->name('fetch-replies');

    Route::delete('delete-question/{id}', [QnaController::class, 'destroyQuestion'])->name('destroy-question');
    Route::delete('delete-reply/{id}', [QnaController::class, 'destroyReply'])->name('destroy-reply');

    /** course review Routes */
    Route::post('add-review', [LearningController::class, 'addReview'])->name('add-review');
    Route::get('fetch-reviews/{course_id}', [LearningController::class, 'fetchReviews'])->name('fetch-reviews');

    /** download certificate route */
    Route::get('download-certificate/{id}', [StudentDashboardController::class, 'downloadCertificate'])->name('download-certificate');
});

/**
 * ============================================================================
 * Instructor Dashboard Routes
 * ============================================================================
 */

Route::group(['middleware' => ['auth', 'verified', 'approved.instructor', 'role:instructor'], 'prefix' => 'instructor', 'as' => 'instructor.'], function () {
    Route::get('dashboard', [InstructorDashboardController::class, 'index'])->name('dashboard');
    // Profile setting routes
    Route::get('zoom-setting', [InstructorLiveCredentialController::class, 'index'])->name('zoom-setting.index');
    Route::put('zoom-setting', [InstructorLiveCredentialController::class, 'update'])->name('zoom-setting.update');
    Route::get('jitsi-setting', [InstructorLiveCredentialController::class, 'jitsi_index'])->name('jitsi-setting.index');
    Route::put('jitsi-setting', [InstructorLiveCredentialController::class, 'jitsi_update'])->name('jitsi-setting.update');
    Route::get('setting', [InstructorProfileSettingController::class, 'index'])->name('setting.index');
    Route::put('setting/profile', [InstructorProfileSettingController::class, 'updateProfile'])->name('setting.profile.update');
    Route::put('setting/bio', [InstructorProfileSettingController::class, 'updateBio'])->name('setting.bio.update');
    Route::put('setting/password', [InstructorProfileSettingController::class, 'updatePassword'])->name('setting.password.update');
    Route::get('setting/experience-modal', [InstructorProfileSettingController::class, 'showExperienceModal'])->name('setting.experience-modal');
    Route::get('setting/edit-experience-modal/{id}', [InstructorProfileSettingController::class, 'editExperienceModal'])->name('setting.edit-experience-modal');

    Route::post('setting/experience', [InstructorProfileSettingController::class, 'storeExperience'])->name('setting.experience.store');
    Route::put('setting/experience/{id}', [InstructorProfileSettingController::class, 'updateExperience'])->name('setting.experience.update');
    Route::delete('setting/experience/{id}', [InstructorProfileSettingController::class, 'destroyExperience'])->name('setting.experience.destroy');

    Route::get('setting/add-education-modal', [InstructorProfileSettingController::class, 'addEducationModal'])->name('setting.add-education-modal');
    Route::post('setting/education', [InstructorProfileSettingController::class, 'storeEducation'])->name('setting.education.store');
    Route::get('setting/edit-education-modal/{id}', [InstructorProfileSettingController::class, 'editEducationModal'])->name('setting.edit-education-modal');
    Route::put('setting/education/{id}', [InstructorProfileSettingController::class, 'updateEducation'])->name('setting.education.update');
    Route::delete('setting/education/{id}', [InstructorProfileSettingController::class, 'destroyEducation'])->name('setting.education.destroy');

    Route::put('setting/payout', [InstructorProfileSettingController::class, 'updatePayout'])->name('setting.payout.update');

    Route::put('setting/address', [InstructorProfileSettingController::class, 'updateAddress'])->name('setting.address.update');
    Route::put('setting/socials', [InstructorProfileSettingController::class, 'updateSocials'])->name('setting.socials.update');

    /** Course Routes */
    Route::get('courses', [InstructorCourseController::class, 'index'])->name('courses.index');
    Route::get('courses/create', [InstructorCourseController::class, 'create'])->name('courses.create');
    Route::get('courses/create/{id}/step/{step?}', [InstructorCourseController::class, 'edit'])->name('courses.edit');
    Route::get('courses/{id}/edit', [InstructorCourseController::class, 'editView'])->name('courses.edit-view');

    Route::get('courses/get-filters/{category_id}', [InstructorCourseController::class, 'getFiltersByCategory'])->name('courses.get-filters');
    Route::get('courses/get-instructors', [InstructorCourseController::class, 'getInstructors'])->name('courses.get-instructors');

    Route::post('courses/create', [InstructorCourseController::class, 'store'])->name('courses.store');
    Route::post('courses/update', [InstructorCourseController::class, 'update'])->name('courses.update');

    /** Course content routes */
    Route::post('course-chapter/{course_id?}/store', [CourseContentController::class, 'chapterStore'])->name('course-chapter.store');
    Route::get('course-chapter/sorting/{course_id}', [CourseContentController::class, 'chapterSorting'])->name('course-chapter.sorting.index');
    Route::get('course-chapter/edit/{chapter_id}', [CourseContentController::class, 'chapterEdit'])->name('course-chapter.edit');
    Route::put('course-chapter/update/{chapter_id}', [CourseContentController::class, 'chapterUpdate'])->name('course-chapter.update');
    Route::delete('course-chapter/delete/{chapter_id}', [CourseContentController::class, 'chapterDestroy'])->name('course-chapter.destroy');

    Route::post('course-chapter/sorting/{course_id}', [CourseContentController::class, 'chapterSortingStore'])->name('course-chapter.sorting.store');
    Route::get('course-chapter/lesson/create', [CourseContentController::class, 'lessonCreate'])->name('course-chapter.lesson.create');
    Route::post('course-chapter/lesson/create', [CourseContentController::class, 'lessonStore'])->name('course-chapter.lesson.store');
    Route::get('course-chapter/lesson/edit', [CourseContentController::class, 'lessonEdit'])->name('course-chapter.lesson.edit');

    Route::post('course-chapter/lesson/update', [CourseContentController::class, 'lessonUpdate'])->name('course-chapter.lesson.update');
    Route::delete('course-chapter/lesson/{chapter_item_id}/destroy', [CourseContentController::class, 'chapterLessonDestroy'])->name('course-chapter.lesson.destroy');
    Route::post('course-chapter/lesson/sorting/{chapter_id}', [CourseContentController::class, 'sortLessons'])->name('course-chapter.lesson.sorting');

    Route::get('course-chapter/quiz-question/create/{quiz_id}', [CourseContentController::class, 'createQuizQuestion'])->name('course-chapter.quiz-question.create');
    Route::post('course-chapter/quiz-question/create/{quiz_id}', [CourseContentController::class, 'storeQuizQuestion'])->name('course-chapter.quiz-question.store');
    Route::get('course-chapter/quiz-question/edit/{question_id}', [CourseContentController::class, 'editQuizQuestion'])->name('course-chapter quiz-question.edit');
    Route::put('course-chapter/quiz-question/update/{question_id}', [CourseContentController::class, 'updateQuizQuestion'])->name('course-chapter.quiz-question.update');
    Route::delete('course-chapter/quiz-question/delete/{question_id}', [CourseContentController::class, 'destroyQuizQuestion'])->name('course-chapter.quiz-question.destroy');
    Route::get('course-delete-request/{course_id}', [InstructorCourseController::class, 'showDeleteRequest'])->name('course.delete-request.show');
    Route::post('course-delete-request', [InstructorCourseController::class, 'sendDeleteRequest'])->name('course.send-delete-request');

    /** payout routes */
    Route::get('payout', [InstructorPayoutController::class, 'index'])->name('payout.index');
    Route::get('payout/create', [InstructorPayoutController::class, 'create'])->name('payout.create');
    Route::post('payout/create', [InstructorPayoutController::class, 'store'])->name('payout.store');
    Route::delete('payout/delete/{id}', [InstructorPayoutController::class, 'destroy'])->name('payout.destroy');

    /** announcement routes */
    Route::resource('announcements', InstructorAnnouncementController::class);

    /** my sales routes */
    Route::get('my-sells', [InstructorDashboardController::class, 'mySells'])->name('my-sells.index');
    /** lessons qna routes */
    Route::get('lesson-question', [InstructorLessonQnaController::class, 'index'])->name('lesson-questions.index');
    Route::post('lesson-question/{id}', [InstructorLessonQnaController::class, 'createReply'])->name('lesson-question.reply');
    Route::delete('lesson-question/destroy/{id}', [InstructorLessonQnaController::class, 'destroyQuestion'])->name('lesson-question.destroy');
    Route::delete('lesson-question/reply/destroy/{id}', [InstructorLessonQnaController::class, 'destroyReply'])->name('lesson-reply.destroy');
    Route::put('lesson-question/seen-update/{id}', [InstructorLessonQnaController::class, 'markAsReadUnread'])->name('lesson-question.seen-update');

});

Route::group(['middleware' => ['auth', 'verified']], function () {
    /** checkout routes */

    /**payment related route start */
    Route::get('payment', [PaymentController::class, 'payment'])->name('payment');
    Route::post('pay-via-stripe', [PaymentController::class, 'pay_via_stripe'])->name('pay-via-stripe');
    Route::get('pay-via-paypal', [PaymentController::class, 'pay_via_paypal'])->name('pay-via-paypal');
    Route::post('pay-via-bank', [PaymentController::class, 'pay_via_bank'])->name('pay-via-bank');
    Route::post('pay-via-razorpay', [PaymentController::class, 'pay_via_razorpay'])->name('pay-via-razorpay');
    Route::get('pay-via-mollie', [PaymentController::class, 'pay_via_mollie'])->name('pay-via-mollie');
    Route::get('pay-via-instamojo', [PaymentController::class, 'pay_via_instamojo'])->name('pay-via-instamojo');
    Route::post('pay-via-flutterwave', [PaymentController::class, 'pay_via_flutterwave'])->name('pay-via-flutterwave');
    Route::post('pay-via-paystack', [PaymentController::class, 'pay_via_paystack'])->name('pay-via-paystack');
    Route::post('pay-via-bank', [PaymentController::class, 'pay_via_bank'])->name('pay-via-bank');
    Route::post('pay-via-free-gateway', [PaymentController::class, 'pay_via_free_gateway'])->name('pay-via-free-gateway');
    Route::get('/payment-addon-success', [PaymentController::class, 'payment_addon_success'])->name('payment-addon-success');
    Route::get('/payment-addon-faild', [PaymentController::class, 'payment_addon_faild'])->name('payment-addon-faild');
    Route::get('order-completed', [PaymentController::class, 'order_success'])->name('order-success');
    Route::get('order-fail', [PaymentController::class, 'order_fail'])->name('order-fail');

    Route::post('tinymce-upload-image', [TinymceImageUploadController::class, 'upload']);
    Route::delete('tinymce-delete-image', [TinymceImageUploadController::class, 'destroy']);
});


require __DIR__ . '/auth.php';

require __DIR__ . '/admin.php';

// Routes pour les partenaires
Route::prefix('admin/partners')->name('admin.partners.')->group(function () {
    Route::get('/', [PartnerController::class, 'index'])->name('index'); // Afficher tous les partenaires
    Route::get('/create', [PartnerController::class, 'create'])->name('create'); // Formulaire pour créer un partenaire
    Route::post('/', [PartnerController::class, 'store'])->name('store'); // Enregistrer un nouveau partenaire
    Route::get('/{id}/edit', [PartnerController::class, 'edit'])->name('edit'); // Formulaire pour éditer un partenaire
    Route::put('/{id}', [PartnerController::class, 'update'])->name('update'); // Mettre à jour un partenaire
    Route::delete('/{id}', [PartnerController::class, 'destroy'])->name('destroy'); // Supprimer un partenaire
});

// routes pour les histoires de succès (success stories)
Route::prefix('admin/success_stories')->name('admin.success_stories.')->group(function () {
    Route::get('/', [SuccessStoryController::class, 'index'])->name('index'); // Afficher toutes les histoires de succès
    Route::get('/create', [SuccessStoryController::class, 'create'])->name('create'); // Formulaire pour créer une histoire de succès
    Route::post('/', [SuccessStoryController::class, 'store'])->name('store'); // Enregistrer une nouvelle histoire de succès
    Route::get('/{id}/edit', [SuccessStoryController::class, 'edit'])->name('edit'); // Formulaire pour éditer une histoire de succès
    Route::put('/{id}', [SuccessStoryController::class, 'update'])->name('update'); // Mettre à jour une histoire de succès
    Route::delete('/{id}', [SuccessStoryController::class, 'destroy'])->name('destroy'); // Supprimer une histoire de succès
});

// routes pour les startups
Route::prefix('admin/startups')->name('admin.startups.')->group(function () {
    Route::get('/', [StartupController::class, 'index'])->name('index'); // Afficher toutes les startups
    Route::get('/create', [StartupController::class, 'create'])->name('create'); // Formulaire pour créer une startup
    Route::post('/', [StartupController::class, 'store'])->name('store'); // Enregistrer une nouvelle startup
    Route::get('/{id}/edit', [StartupController::class, 'edit'])->name('edit'); // Formulaire pour éditer une startup
    Route::put('/{id}', [StartupController::class, 'update'])->name('update'); // Mettre à jour une startup
    Route::delete('/{id}', [StartupController::class, 'destroy'])->name('destroy'); // Supprimer une startup
});
