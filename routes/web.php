<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Kashmir Sheeps & HADP Digital Ecosystem Full-Stack Interface
|
*/

Route::get('/', function () {
    return view('app');
})->name('home');
