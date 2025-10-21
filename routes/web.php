<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

use App\Http\Controllers\ActivityController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PasswordRecoveryController;
use App\Http\Controllers\AccountController;

Route::middleware('auth')->group(function () {
    Route::get('/activities', [ActivityController::class, 'index'])->name('activities.index');
    Route::post('/activities', [ActivityController::class, 'store'])->name('activities.store');
    Route::get('/activities/{activity}/edit', [ActivityController::class, 'edit'])->name('activities.edit');
    Route::put('/activities/{activity}', [ActivityController::class, 'update'])->name('activities.update');
    Route::delete('/activities/{activity}', [ActivityController::class, 'destroy'])->name('activities.destroy');
    Route::get('/activities/pdf/daily', [ActivityController::class, 'dailyPdf'])->name('activities.dailyPdf');
    Route::get('/activities/pdf/weekly', [ActivityController::class, 'weeklyPdf'])->name('activities.weeklyPdf');
});

// Auth
Route::get('/register', [AuthController::class, 'showRegister'])->name('register.show');
Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::get('/login', [AuthController::class, 'showLogin'])->name('login.show');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Password recovery via security questions
Route::get('/password/email', [PasswordRecoveryController::class, 'requestEmail'])->name('password.email');
Route::post('/password/email', [PasswordRecoveryController::class, 'postEmail'])->name('password.email.post');
Route::get('/password/questions/{user}', [PasswordRecoveryController::class, 'showQuestions'])->name('password.questions');
Route::post('/password/questions/{user}', [PasswordRecoveryController::class, 'verifyQuestions'])->name('password.questions.verify');
Route::get('/password/reset/{user}', [PasswordRecoveryController::class, 'showResetForm'])->name('password.reset.form');
Route::post('/password/reset/{user}', [PasswordRecoveryController::class, 'resetPassword'])->name('password.reset');

// Account routes
Route::middleware('auth')->group(function () {
    Route::get('/account/password', [AccountController::class, 'showChangePassword'])->name('account.password.show');
    Route::post('/account/password', [AccountController::class, 'updatePassword'])->name('account.password.update');
});

