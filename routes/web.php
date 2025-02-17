<?php

use App\Http\Controllers\Cart\CartController;
use App\Http\Controllers\Catalog\CatalogController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Product\ProductController;
use App\Http\Middleware\CatalogViewMiddleware;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\SocialiteController;
use App\Http\Controllers\Auth\SignInController;
use App\Http\Controllers\Auth\SignUpController;
use App\Http\Controllers\Auth\LostPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;


Route::get('/', HomeController::class)->name('home');


Route::get('/catalog/{category:slug?}', CatalogController::class)
    ->middleware(CatalogViewMiddleware::class)
    ->name('catalog');


Route::controller(CartController::class)
    ->prefix('cart')
    ->group(
        function () {
            Route::get('/', 'index')->name('cart');
            Route::post('/add/{product:slug}', 'add')->name('cart.add');
            Route::post('/quantity/{cartItem}', 'quantity')->name('cart.quantity');
            Route::delete('/delete/{cartItem}', 'delete')->name('cart.delete');
            Route::delete('/truncate', 'truncate')->name('cart.truncate');
        }
    );


Route::get('/product/{product:slug}', ProductController::class)
    ->name('product.show');


Route::controller(SignInController::class)->group(function () {
    Route::get('/signIn', 'page')
        ->name('signIn');
    Route::post('/login', 'handle')
        ->middleware('throttle:auth')
        ->name('login');
    Route::delete('/logout', 'logout')->name('logout');
});

Route::controller(SignUpController::class)->group(function () {
    Route::get('/signUp', 'page')
        ->name('signUp');
    Route::post('/register', 'handle')
        ->middleware('throttle:auth')
        ->name('register');
});

Route::controller(LostPasswordController::class)->group(function () {
    Route::get('/lost', 'page')
        ->middleware('guest')
        ->name('password.request');
    Route::post('/lost-password', 'handle')
        ->middleware('guest')
        ->name('password.email');
});

Route::controller(ResetPasswordController::class)->group(function () {
    Route::get('/reset-password/{token}', 'page')
        ->middleware('guest')
        ->name('password.reset');

    Route::post('/reset-password', 'handle')
        ->middleware('guest')
        ->name('password.update');
});

Route::controller(SocialiteController::class)->group(function () {
    Route::get('/auth/socialite/{driver}', 'redirect')
        ->name('socialite');

    Route::get('/auth/socialite/{driver}/callback', 'callback')
        ->name('socialite.callback');
});


