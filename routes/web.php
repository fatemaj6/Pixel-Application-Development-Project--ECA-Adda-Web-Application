<?php

use Illuminate\Support\Facades\Route;

// Controllers
use App\Http\Controllers\LandingController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\AdminLoginController;
use App\Http\Controllers\Auth\OtpController;
use App\Http\Controllers\ECAController;
use App\Http\Controllers\Admin\AdminEcaController;
use App\Http\Controllers\Admin\AdminHomeController;
use App\Http\Controllers\Admin\RegistrationController;
use App\Http\Controllers\Admin\EnrollmentController;
use App\Http\Controllers\Admin\QueryController;
/*
|--------------------------------------------------------------------------
| Landing Page
|--------------------------------------------------------------------------
*/

Route::get('/', [LandingController::class, 'index'])->name('landing');


/*
|--------------------------------------------------------------------------
| USER AUTHENTICATION (Login + OTP)
|--------------------------------------------------------------------------
*/

// Show login form
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');

// Send OTP
Route::post('/login', [LoginController::class, 'sendOtp'])->name('login.sendOtp');

// Show OTP input page
Route::get('/login/otp', [LoginController::class, 'showOtpForm'])->name('login.otp');

// Verify OTP
Route::post('/login/verify', [OtpController::class, 'verifyOtp'])->name('login.verify');


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
| ADMIN LOGIN + OTP
|--------------------------------------------------------------------------
*/

// Show admin login page
Route::get('/admin/login', [AdminLoginController::class, 'showLoginForm'])
    ->name('admin.login');

// POST: Send OTP to admin email
Route::post('/admin/login', [AdminLoginController::class, 'login'])
    ->name('admin.login.post');

// GET: Show OTP form
Route::get('/admin/login/otp', [AdminLoginController::class, 'showOtpForm'])
    ->name('admin.login.otp');

// POST: Verify OTP
Route::post('/admin/login/verify', [AdminLoginController::class, 'verifyOtp'])
    ->name('admin.login.verify');

// ECA LIST
Route::get('/eca', [ECAController::class, 'index'])->name('eca.index');

// ECA DETAILS
Route::get('/eca/{id}', [ECAController::class, 'show'])->name('eca.show');

// JOIN ECA
Route::post('/eca/{id}/join', [ECAController::class, 'join'])->middleware('auth')->name('eca.join');

// My ECAs
Route::get('/my-ecas', [ECAController::class, 'myEcas'])->middleware('auth')->name('eca.my');

Route::middleware(['auth:admin'])->prefix('admin')->group(function () {

    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');

    Route::resource('eca', AdminEcaController::class);
});

Route::prefix('admin')->name('admin.')->middleware('auth:admin')->group(function () {
    Route::get('/dashboard', [AdminHomeController::class, 'index'])->name('dashboard');

    // Registrations
    Route::get('/registrations', [RegistrationController::class, 'index'])->name('registrations.index');
    Route::get('/registrations/{user}', [RegistrationController::class, 'show'])->name('registrations.show');
    Route::post('/registrations/{user}/approve', [RegistrationController::class, 'approve'])->name('registrations.approve');
    Route::post('/registrations/{user}/correction', [RegistrationController::class, 'requestCorrection'])->name('registrations.correction');
    Route::post('/registrations/{user}/reject', [RegistrationController::class, 'reject'])->name('registrations.reject');


    // Enrollments
    Route::get('/enrollments', [EnrollmentController::class, 'index'])->name('enrollments.index');
    Route::post('/enrollments/{enrollment}/done', [EnrollmentController::class, 'markDone'])->name('enrollments.done');

    // Queries
    Route::get('/queries', [QueryController::class, 'index'])->name('queries.index');
    Route::get('/queries/{query}', [QueryController::class, 'show'])->name('queries.show');
    Route::post('/queries/{query}/reply', [QueryController::class, 'reply'])->name('queries.reply');
});


Route::prefix('admin')->group(function () {
    Route::get('/ecas', [AdminEcaController::class, 'index'])->name('admin.ecas.index');
    Route::get('/ecas/create', [AdminEcaController::class, 'create'])->name('admin.ecas.create');
    Route::post('/ecas', [AdminEcaController::class, 'store'])->name('admin.ecas.store');
    Route::get('/ecas/{id}/edit', [AdminEcaController::class, 'edit'])->name('admin.ecas.edit');
    Route::put('/ecas/{id}', [AdminEcaController::class, 'update'])->name('admin.ecas.update');
    Route::delete('/ecas/{id}', [AdminEcaController::class, 'destroy'])->name('admin.ecas.destroy');
});

?>
