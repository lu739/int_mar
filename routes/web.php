<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    logger()->channel('telegram')->debug('Hello');

    return view('welcome');
});
