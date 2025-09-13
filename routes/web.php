<?php

use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordResetController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\SessionController;
use App\Http\Controllers\Auth\VerificationController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\PostTrashController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\Users\ProfileController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function() {
    Route::get('auth/login', [SessionController::class, 'create'])->name('login');
    Route::post('auth/login', [SessionController::class, 'store']);
    Route::get('auth/register', [RegisterController::class, 'create'])->name('register');
    Route::post('auth/register', [RegisterController::class, 'store']);
    Route::get('/forgot-password', [PasswordResetController::class, 'create'])->name('password.request');
    Route::post('/forgot-password', [PasswordResetController::class, 'store'])->name('password.email');
    Route::get('/reset-password/{token}', [NewPasswordController::class, 'create'])->name('password.reset');
    Route::post('/reset-password', [NewPasswordController::class, 'store'])->name('password.update');
});
Route::middleware('auth')->group(function() {
    // AUTH CONTROLLER
    Route::post('/auth/logout', [SessionController::class, 'logout'])->name('logout');
    Route::get('/email/verify/{id}/{hash}', [VerificationController::class, 'verify'])->middleware('signed')->name('verification.verify');
    Route::post('/email/verification-notification', [VerificationController::class, 'repeatSendMail'])->middleware('throttle:10,1')->name('verification.send');
    Route::get('/forgot-password', [PasswordResetController::class, 'create'])->name('password.request');
    Route::post('/forgot-password', [PasswordResetController::class, 'store'])->name('password.email');
    Route::get('/reset-password/{token}', [NewPasswordController::class, 'create'])->name('password.reset');
    Route::post('/reset-password', [NewPasswordController::class, 'store'])->name('password.update');
    Route::get('/unverified', fn() => view('auth/unverified'))->name('verification.notice');
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    // ADMIN CONTROLLER
    Route::resource('posts', PostController::class);
    Route::resource('post-trash', PostTrashController::class)->except('show', 'create', 'store', 'edit');
    Route::resource('categories', CategoryController::class);
    Route::patch('/posts/{post}', [ PostController::class, 'publish' ])->name('posts.publish');
    Route::resource('shops', ShopController::class);
    Route::put('shops/{shop}/detach-all-products', [ShopController::class, 'detachAllProducts']);
});


