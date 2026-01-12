<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// Controllers
use App\Http\Controllers\LandingController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\AdminLoginController;
use App\Http\Controllers\Auth\OtpController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\Admin\AdminBlogController;

use App\Http\Controllers\ECAController;
use App\Http\Controllers\OneToOneController;
use App\Http\Controllers\SessionController; 
use App\Http\Controllers\GeminiTestController; 
use App\Http\Controllers\PaymentController;

use App\Http\Controllers\User\DashboardController;
use App\Http\Controllers\User\ProfileController;
use App\Http\Controllers\User\CalendarController;
use App\Http\Controllers\User\EventController;
use App\Http\Controllers\User\AIController;
use App\Http\Controllers\User\QueryController as UserQueryController;
use App\Http\Controllers\User\AdminMessageController as UserAdminMessageController;

use App\Http\Controllers\Admin\AdminHomeController;
use App\Http\Controllers\Admin\RegistrationController;
use App\Http\Controllers\Admin\EnrollmentController;
use App\Http\Controllers\Admin\QueryController;
use App\Http\Controllers\Admin\AdminEcaController;
use App\Http\Controllers\Admin\UserController as AdminUserController;

use App\Http\Controllers\InteractionHubController; 
use App\Http\Controllers\ChatController; 
use App\Http\Controllers\AchievementController; 
use App\Http\Controllers\ReactionController;




/*
|--------------------------------------------------------------------------
| Landing Page
|--------------------------------------------------------------------------
*/
Route::get('/', [LandingController::class, 'index'])->name('landing');
Route::get('/blogs', [BlogController::class, 'index'])->name('blogs.index'); 
Route::get('/blogs/{blog}', [BlogController::class, 'show'])->name('blogs.show');
Route::middleware('auth')->group(function () { 
Route::post('/blogs/{blog}/comment', [BlogController::class, 'comment'])->name('blogs.comment'); 
Route::post('/blogs/{blog}/like', [BlogController::class, 'like'])->name('blogs.like'); 
Route::delete('/blogs/{blog}/unlike', [BlogController::class, 'unlike'])->name('blogs.unlike'); });

/*
|--------------------------------------------------------------------------
| USER AUTHENTICATION (Login + OTP)
|--------------------------------------------------------------------------
*/
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'sendOtp'])->name('login.sendOtp');
Route::get('/forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('/reset-password/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('/reset-password', [ResetPasswordController::class, 'reset'])->name('password.update');
Route::get('/login/otp', [LoginController::class, 'showOtpForm'])->name('login.otp');
Route::post('/login/verify', [OtpController::class, 'verifyOtp'])->name('login.verify');

Route::post('/logout', function () {
    Auth::logout();
    return redirect('/')->with('success', 'Logged out successfully.');
})->name('logout');

/*
|--------------------------------------------------------------------------
| USER REGISTRATION (Multi-step)
|--------------------------------------------------------------------------
*/
Route::get('/register/step1', [RegisterController::class, 'step1'])->name('register.step1');
Route::post('/register/step1', [RegisterController::class, 'storeStep1'])->name('register.storeStep1');
Route::get('/register/step2', [RegisterController::class, 'step2'])->name('register.step2');
Route::post('/register/step2', [RegisterController::class, 'storeStep2'])->name('register.storeStep2');
Route::get('/register/step3', [RegisterController::class, 'step3'])->name('register.step3');
Route::post('/register/step3', [RegisterController::class, 'complete'])->name('register.complete');

/*
|--------------------------------------------------------------------------
| ECA ROUTES (User side)
|--------------------------------------------------------------------------
*/
Route::get('/eca', [ECAController::class, 'index'])->name('eca.index');
Route::get('/eca/{id}', [ECAController::class, 'show'])->name('eca.show');
Route::post('/eca/{id}/join', [ECAController::class, 'join'])->middleware('auth')->name('eca.join');
Route::get('/my-ecas', [ECAController::class, 'myEcas'])->middleware('auth')->name('eca.my');

/*
|--------------------------------------------------------------------------
| USER DASHBOARD
|--------------------------------------------------------------------------
Route::middleware(['auth'])->prefix('dashboard')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard.index');
*/
Route::middleware(['auth', 'payment.done'])
    ->prefix('dashboard')
    ->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard.index');
    // other dashboard routes

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('dashboard.profile');
    Route::put('/profile', [ProfileController::class, 'update'])->name('dashboard.profile.update');
    Route::get('/subscription', [ProfileController::class, 'subscription'])->name('dashboard.subscription');
    Route::get('/security', [ProfileController::class, 'security'])->name('dashboard.security');
    Route::put('/security', [ProfileController::class, 'updatePassword'])->name('dashboard.password.update');

    // AI Advisor
    Route::get('/ai-chat', [AIController::class, 'index'])->name('dashboard.aidash');
    Route::post('/ai-chat/send', [AIController::class, 'chat'])->name('dashboard.aidash.send');
    Route::get('/gemini-test', [GeminiTestController::class, 'test']);

    // ECAs
    Route::get('/ecas', [ECAController::class, 'index'])->name('dashboard.ecas');

    // Queries
    Route::get('/query', [UserQueryController::class, 'create'])->name('dashboard.query.create');
    Route::post('/query', [UserQueryController::class, 'store'])->name('dashboard.query.store');

    // Calendar
    Route::get('/calendar', [CalendarController::class, 'myEvents'])->name('calendar.my-events');
    Route::get('/calendar/deadlines', [CalendarController::class, 'deadlines'])->name('calendar.deadlines');
    Route::get('/calendar/sessions', [CalendarController::class, 'sessions'])->name('calendar.sessions');

    // One-to-One Session
    Route::get('/session', [\App\Http\Controllers\OneToOneController::class, 'create'])
        ->name('dashboard.session');
    Route::get('/session/instructor/{instructor}', [\App\Http\Controllers\OneToOneController::class, 'showInstructor'])
        ->name('dashboard.session.instructor');
    Route::post('/session', [\App\Http\Controllers\OneToOneController::class, 'store'])
        ->name('dashboard.session.store');

    // Events
    Route::get('/events/create', [EventController::class, 'create'])->name('events.create');
    Route::post('/events/store', [EventController::class, 'store'])->name('events.store');
    Route::get('/events/{event}/edit', [EventController::class, 'edit'])->name('events.edit');
    Route::put('/events/{event}', [EventController::class, 'update'])->name('events.update');
    Route::delete('/events/{event}', [EventController::class, 'destroy'])->name('events.destroy');

    // ✅ Interaction Hub main page
    Route::get('/hub', [InteractionHubController::class, 'index'])
        ->name('dashboard.hub');

    // ✅ Group Chat
    Route::post('/chat/send', [ChatController::class, 'store'])
        ->name('dashboard.chat.send');

    // ✅ Achievements
    Route::post('/achievements/upload', [AchievementController::class, 'store'])
        ->name('dashboard.achievements.upload');

    // ✅ Reactions
    Route::post('/achievements/{id}/react', [ReactionController::class, 'store'])
        ->name('dashboard.achievements.react');
});
/*
|--------------------------------------------------------------------------
| ADMIN DASHBOARD + MANAGEMENT
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->middleware(['auth:admin'])->name('admin.')->group(function () {
    // Dashboard
    Route::get('/dashboard', [AdminHomeController::class, 'index'])->name('dashboard');

    // ECA Management
    Route::resource('ecas', AdminEcaController::class);

    // Blog Management
    Route::resource('blogs', AdminBlogController::class);

    // Registrations
    Route::get('/registrations', [RegistrationController::class, 'index'])->name('registrations.index');
    Route::get('/registrations/{user}', [RegistrationController::class, 'show'])->name('registrations.show');
    Route::post('/registrations/{user}/approve', [RegistrationController::class, 'approve'])->name('registrations.approve');
    Route::post('/registrations/{user}/correction', [RegistrationController::class, 'requestCorrection'])->name('registrations.correction');
    Route::post('/registrations/{user}/reject', [RegistrationController::class, 'reject'])->name('registrations.reject');

    // Users
    Route::get('/users', [AdminUserController::class, 'index'])->name('users.index');
    Route::get('/users/{user}', [AdminUserController::class, 'show'])->name('users.show');
    Route::get('/users/{user}/message', [AdminUserController::class, 'message'])->name('users.message');
    Route::post('/users/{user}/message', [AdminUserController::class, 'sendMessage'])->name('users.message.send');

    // Enrollments
    Route::get('/enrollments', [EnrollmentController::class, 'index'])->name('enrollments.index');
    Route::post('/enrollments/{enrollment}/done', [EnrollmentController::class, 'markDone'])->name('enrollments.done');
    Route::post('/enrollments/{enrollment}/rollback', [EnrollmentController::class, 'rollback'])->name('enrollments.rollback');

    // Queries
    Route::get('/queries', [QueryController::class, 'index'])->name('queries.index');
    Route::get('/queries/{query}', [QueryController::class, 'show'])->name('queries.show');
    Route::post('/queries/{query}/reply', [QueryController::class, 'reply'])->name('queries.reply');
});

/*
|--------------------------------------------------------------------------
| ADMIN LOGIN (OTP) AND LOGOUT
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/login', [AdminLoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AdminLoginController::class, 'login'])->name('login.post');
    Route::get('/login/otp', [AdminLoginController::class, 'showOtpForm'])->name('login.otp');
    Route::post('/login/verify', [AdminLoginController::class, 'verifyOtp'])->name('login.verify');
});
// admin log out
Route::post('/admin/logout', function () {
    Auth::guard('admin')->logout();
    return redirect('/admin/login')->with('success', 'Logged out successfully.');
})->name('admin.logout');

//Payment Routes
Route::middleware('auth')->group(function () {

    // Stripe checkout page
    Route::get('/payment/checkout', [PaymentController::class, 'checkout'])
        ->name('payment.checkout');

    // Create Stripe session
    Route::post('/payment/create-session', [PaymentController::class, 'createSession'])
        ->name('payment.create');

    // Stripe success callback
    Route::get('/payment/success', [PaymentController::class, 'success'])
        ->name('payment.success');

    // Stripe cancel callback
    Route::get('/payment/cancel', [PaymentController::class, 'cancel'])
        ->name('payment.cancel');

    // ✅ Payment history (NO payment.done)
    Route::get('/dashboard/payments', [PaymentController::class, 'history'])
        ->middleware('payment.done')
        ->name('dashboard.payments');
});

Route::middleware(['auth', 'payment.done'])->prefix('dashboard')->group(function () {
    Route::get('/messages', [UserAdminMessageController::class, 'index'])->name('dashboard.messages');
    Route::post('/messages/{message}/read', [UserAdminMessageController::class, 'markRead'])->name('dashboard.messages.read');
    Route::delete('/messages/{message}', [UserAdminMessageController::class, 'destroy'])->name('dashboard.messages.delete');
});

?>
