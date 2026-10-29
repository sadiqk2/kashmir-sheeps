<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Kashmir Sheeps Full-Stack Digital Marketplace
|
*/

Route::get('/', function () {
    return view('app');
})->name('home');
