<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::controller(\App\Http\Controllers\AuthController::class)->group(function () {
    Route::delete('/logout', 'logout')->name('logout');
    Route::post('/login', 'login')
        ->middleware('throttle:auth')
        ->name('login');
    Route::get('/signUp', 'signUp')->name('signUp');
    Route::post('/register', 'register')
        ->middleware('throttle:auth')
        ->name('register');
    Route::get('/signIn', 'signIn')->name('signIn');

    Route::get('/lost', 'lost')
        ->middleware('guest')
        ->name('password.request');
    Route::post('/lost-password', 'lostPassword')
        ->middleware('guest')
        ->name('password.email');
    Route::get('/reset-password/{token}', 'reset')
        ->middleware('guest')
        ->name('password.reset');

    Route::post('/reset-password', 'resetPassword')
        ->middleware('guest')
        ->name('password.update');

    Route::get('/auth/socialite/github', 'github')
        ->name('socialite.github');

    Route::get('/auth/socialite/github/callback', 'githubCallback')
        ->name('socialite.github.callback');
});


