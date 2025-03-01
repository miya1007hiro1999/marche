<?php

use App\Http\Controllers\Owner\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Owner\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Owner\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Owner\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Owner\Auth\NewPasswordController;
use App\Http\Controllers\Owner\Auth\PasswordController;
use App\Http\Controllers\Owner\Auth\PasswordResetLinkController;
use App\Http\Controllers\Owner\Auth\RegisteredUserController;
use App\Http\Controllers\Owner\Auth\VerifyEmailController;
use App\Http\Controllers\Owner\ShopController;
use App\Http\Controllers\Owner\ImageController;
use App\Http\Controllers\Owner\ProductController;
use App\Models\Product;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;



// Route::get('/', function () {
//     return view('owner.welcome');
// });

Route::prefix('shops')->middleware('auth:owners')->group(function(){
    Route::get('index',[ShopController::class,'index'])->name('shops.index');
    Route::get('edit/{shop}',[ShopController::class,'edit'])->name('shops.edit');
    Route::post('update/{shop}',[ShopController::class,'update'])->name('shops.update');
});

Route::prefix('images')->middleware('auth:owners')->group(function(){
    Route::get('index',[ImageController::class,'index'])->name('images.index');
    Route::get('edit/{image}',[ImageController::class,'edit'])->name('images.edit');
    Route::post('store',[ImageController::class,'store'])->name('images.store');
    Route::get('create',[ImageController::class,'create'])->name('images.create');
    Route::put('update/{image}',[ImageController::class,'update'])->name('images.update');
    Route::delete('destroy/{image}',[ImageController::class,'destroy'])->name('images.destroy');
});

// Route::prefix('products')->middleware('auth:owners')->group(function(){
//     Route::get('index',[ProductController::class,'index'])->name('products.index');
//     Route::get('edit/{product}',[ProductController::class,'edit'])->name('products.edit');
//     Route::post('store',[ProductController::class,'store'])->name('products.store');
//     Route::get('create',[ProductController::class,'create'])->name('products.create');
//     Route::put('update/{product}',[ProductController::class,'update'])->name('products.update');
//     Route::delete('destroy/{product}',[ProductController::class,'destroy'])->name('products.destroy');
// });

// Route::resource('images' , ImageController::class)
// ->except(['show']);
//ここがなんでか反応しなかった。上記のように一つずつ書くとルーティングできた。
// middlewareがなかったから。
Route::resource('products' , ProductController::class)
->middleware('auth:owners')->except(['show']);

Route::get('/dashboard', function () {
    return view('owner.dashboard');
})->middleware(['auth:owners', 'verified'])->name('dashboard');

Route::middleware('auth:owners')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});





Route::middleware('guest')->group(function () {
    // Route::get('register', [RegisteredUserController::class, 'create'])
    //             ->name('register');

    // Route::post('register', [RegisteredUserController::class, 'store']);

    Route::get('login', [AuthenticatedSessionController::class, 'create'])
                ->name('login');

    Route::post('login', [AuthenticatedSessionController::class, 'store']);

    Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])
                ->name('password.request');

    Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])
                ->name('password.email');

    Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])
                ->name('password.reset');

    Route::post('reset-password', [NewPasswordController::class, 'store'])
                ->name('password.store');
});

Route::middleware('auth')->group(function () {
    Route::get('verify-email', EmailVerificationPromptController::class)
                ->name('verification.notice');

    Route::get('verify-email/{id}/{hash}', VerifyEmailController::class)
                ->middleware(['auth:owners','signed', 'throttle:6,1'])
                ->name('verification.verify');

    Route::post('email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
                ->middleware('auth:owners','throttle:6,1')
                ->name('verification.send');

    Route::get('confirm-password', [ConfirmablePasswordController::class, 'show'])
                ->name('password.confirm');

    Route::post('confirm-password', [ConfirmablePasswordController::class, 'store']);

    Route::put('password', [PasswordController::class, 'update'])->name('password.update');

    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
                ->name('logout');
});

