<?php

use App\Http\Controllers\Api\HealthCheckController;
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

Route::get('/health', HealthCheckController::class)->name('health');

Route::get('/marketing-short', function () {
    return view('marketing-short');
})->name('marketing.short');
