<?php

use Illuminate\Support\Facades\Route;

// Domain-Driven V1 REST Controllers
use App\Http\Controllers\Api\V1\LivestockListingController as V1LivestockController;
use App\Http\Controllers\Api\V1\OrderController as V1OrderController;
use App\Http\Controllers\Api\V1\HadpApplicationController as V1HadpController;
use App\Http\Controllers\Api\V1\InaphPassportController as V1InaphController;
use App\Http\Controllers\Api\V1\ClinicalDiagnosisController as V1ClinicalController;
use App\Http\Controllers\Api\V1\WoolLabController as V1WoolLabController;
use App\Http\Controllers\Api\V1\BahakTransitController as V1BahakController;

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

    // 3. HADP Government DBT Domain
    Route::get('hadp', [V1HadpController::class, 'index']);
    Route::post('hadp', [V1HadpController::class, 'store']);
    Route::get('hadp/{refNo}', [V1HadpController::class, 'show']);
    Route::post('hadp/{refNo}/advance-stage', [V1HadpController::class, 'advanceStage']);

    // 4. Veterinary & INAPH Domain
    Route::get('inaph', [V1InaphController::class, 'index']);
    Route::post('inaph', [V1InaphController::class, 'store']);
    Route::get('inaph/{tagNo}', [V1InaphController::class, 'show']);
    Route::post('clinical/diagnose', [V1ClinicalController::class, 'diagnose']);
    Route::post('clinical/dosage', [V1ClinicalController::class, 'dosage']);

    // 5. Pastoral & Transhumance Domain
    Route::get('wool-lab', [V1WoolLabController::class, 'index']);
    Route::post('wool-lab/analyze', [V1WoolLabController::class, 'analyze']);
    Route::get('wool-lab/{sampleCode}', [V1WoolLabController::class, 'show']);
    Route::get('bahak-transit', [V1BahakController::class, 'index']);
    Route::post('bahak-transit', [V1BahakController::class, 'store']);
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
Route::get('hadp', [V1HadpController::class, 'index']);
Route::post('hadp', [V1HadpController::class, 'store']);
Route::get('hadp/{refNo}', [V1HadpController::class, 'show']);
Route::post('hadp/{refNo}/advance-stage', [V1HadpController::class, 'advanceStage']);
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
