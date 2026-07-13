<?php
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Password;

Route::get('/', function () {
    return view('welcome');
});


Route::middleware(['auth', 'permission:manage_users'])->group(function () {
    Route::get('/admin/users', [UserController::class, 'index'])->name('admin.users.index');
});


Route::middleware('guest')->group(function () {
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/forgot-password', [AuthController::class, 'showVerifyEmail'])->name('password.request');
    Route::post('/forgot-password', [AuthController::class, 'verifyEmail'])->name('verify.email');

    Route::get('/verify-code', function() { return view('auth.passwords.verify-code'); })->name('password.verify.code.view');
    Route::post('/verify-code', [AuthController::class, 'verifyCode'])->name('verify.code.submit');

    Route::get('/reset-new', function() {
        if (!session()->has('email')) {
            return redirect()->route('password.request');
        }
        return view('auth.passwords.reset-new');
    })->name('password.reset.new.view');
    Route::post('/reset-new', [AuthController::class, 'updatePassword'])->name('password.update.submit');
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () { return view('dashboard'); })->name('dashboard');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});


