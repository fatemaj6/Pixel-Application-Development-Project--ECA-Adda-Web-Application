<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\AdminLoginController;
use App\Http\Controllers\OtpController;

// Landing Page
Route::get('/', [LandingController::class, 'index'])->name('landing');

// User Login + OTP
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'sendOtp']);
Route::post('/login/verify', [OtpController::class, 'verifyOtp'])->name('login.verify');

// User Registration Steps
Route::get('/register/step1', [RegisterController::class, 'step1']);
Route::post('/register/step1', [RegisterController::class, 'storeStep1']);
Route::get('/register/step2', [RegisterController::class, 'step2']);
Route::post('/register/step2', [RegisterController::class, 'storeStep2']);
Route::get('/register/step3', [RegisterController::class, 'step3']);
Route::post('/register/step3', [RegisterController::class, 'complete']);

// Admin Login + OTP
Route::get('/admin/login', [AdminLoginController::class, 'showLoginForm']);
Route::post('/admin/login', [AdminLoginController::class, 'login']);
Route::post('/admin/login/verify', [AdminLoginController::class, 'verifyOtp']);
?>
