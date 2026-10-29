<?php

use Illuminate\Support\Facades\Route;

// Domain-Driven V1 REST Controllers
use App\Http\Controllers\Api\V1\LivestockListingController as V1LivestockController;
use App\Http\Controllers\Api\V1\OrderController as V1OrderController;
use App\Http\Controllers\Api\V1\InaphPassportController as V1InaphController;
use App\Http\Controllers\Api\V1\ClinicalDiagnosisController as V1ClinicalController;
use App\Http\Controllers\Api\V1\WoolLabController as V1WoolLabController;
use App\Http\Controllers\Api\V1\BahakTransitController as V1BahakController;
use App\Http\Controllers\Api\V1\AuthController as V1AuthController;
use App\Http\Controllers\Api\HealthCheckController;

/*
|--------------------------------------------------------------------------
| RESTful API V1 Routes (Domain-Driven Design Architecture)
|--------------------------------------------------------------------------
*/
Route::prefix('v1')->group(function () {
    // 1. Livestock Domain
    Route::apiResource('livestock', V1LivestockController::class);

    // 2. Ordering Domain
    Route::get('orders', [V1OrderController::class, 'index']);
    Route::post('orders', [V1OrderController::class, 'store']);
    Route::get('orders/{orderNo}', [V1OrderController::class, 'show']);
    Route::post('orders/{orderNo}/cancel', [V1OrderController::class, 'cancel']);
    Route::post('orders/{orderNo}/advance-tracking', [V1OrderController::class, 'advanceTracking']);

    // 3. Veterinary & INAPH Domain
    Route::get('inaph', [V1InaphController::class, 'index']);
    Route::post('inaph', [V1InaphController::class, 'store']);
    Route::get('inaph/{tagNo}', [V1InaphController::class, 'show']);
    Route::post('clinical/diagnose', [V1ClinicalController::class, 'diagnose']);
    Route::post('clinical/dosage', [V1ClinicalController::class, 'dosage']);

    // 4. Pastoral & Transhumance Domain
    Route::get('wool-lab', [V1WoolLabController::class, 'index']);
    Route::post('wool-lab/analyze', [V1WoolLabController::class, 'analyze']);
    Route::get('wool-lab/{sampleCode}', [V1WoolLabController::class, 'show']);
    Route::get('bahak-transit', [V1BahakController::class, 'index']);
    Route::post('bahak-transit', [V1BahakController::class, 'store']);

    // 6. System Health Check
    Route::get('health', HealthCheckController::class);
    Route::get('health', HealthCheckController::class);

Route::post('auth/register', [V1AuthController::class, 'register']);
    Route::post('auth/login', [V1AuthController::class, 'login']);
    Route::get('auth/roles', [V1AuthController::class, 'roles']);
    Route::get('users/sellers', [V1AuthController::class, 'sellers']);
    Route::get('users/buyers', [V1AuthController::class, 'buyers']);

    Route::middleware('auth:sanctum')->group(function () {
        Route::get('auth/me', [V1AuthController::class, 'me']);
        Route::post('auth/logout', [V1AuthController::class, 'logout']);
    });
});

/*
|--------------------------------------------------------------------------
| Unversioned Aliases (Backward Compatibility)
|--------------------------------------------------------------------------
*/
Route::apiResource('livestock', V1LivestockController::class);
Route::get('orders', [V1OrderController::class, 'index']);
Route::post('orders', [V1OrderController::class, 'store']);
Route::get('orders/{orderNo}', [V1OrderController::class, 'show']);
Route::post('orders/{orderNo}/cancel', [V1OrderController::class, 'cancel']);
Route::post('orders/{orderNo}/advance-tracking', [V1OrderController::class, 'advanceTracking']);
Route::get('inaph', [V1InaphController::class, 'index']);
Route::post('inaph', [V1InaphController::class, 'store']);
Route::get('inaph/{tagNo}', [V1InaphController::class, 'show']);
Route::post('clinical/diagnose', [V1ClinicalController::class, 'diagnose']);
Route::post('clinical/dosage', [V1ClinicalController::class, 'dosage']);
Route::get('wool-lab', [V1WoolLabController::class, 'index']);
Route::post('wool-lab/analyze', [V1WoolLabController::class, 'analyze']);
Route::get('wool-lab/{sampleCode}', [V1WoolLabController::class, 'show']);
Route::get('bahak-transit', [V1BahakController::class, 'index']);
Route::post('bahak-transit', [V1BahakController::class, 'store']);

Route::get('health', HealthCheckController::class);

Route::post('auth/register', [V1AuthController::class, 'register']);
Route::post('auth/login', [V1AuthController::class, 'login']);
Route::get('auth/roles', [V1AuthController::class, 'roles']);
Route::get('users/sellers', [V1AuthController::class, 'sellers']);
Route::get('users/buyers', [V1AuthController::class, 'buyers']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('auth/me', [V1AuthController::class, 'me']);
    Route::post('auth/logout', [V1AuthController::class, 'logout']);
});
