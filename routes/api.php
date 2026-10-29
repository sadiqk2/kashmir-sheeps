<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\LivestockListingController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\HadpApplicationController;
use App\Http\Controllers\Api\InaphPassportController;
use App\Http\Controllers\Api\ClinicalDiagnosisController;
use App\Http\Controllers\Api\WoolLabController;
use App\Http\Controllers\Api\BahakTransitController;

// 1. Livestock Listings (Sheep, Rams, Farm Products, Manure, Wool)
Route::apiResource('livestock', LivestockListingController::class);

// 2. Orders & Checkout Management
Route::get('orders', [OrderController::class, 'index']);
Route::post('orders', [OrderController::class, 'store']);
Route::get('orders/{orderNo}', [OrderController::class, 'show']);
Route::post('orders/{orderNo}/cancel', [OrderController::class, 'cancel']);
Route::post('orders/{orderNo}/advance-tracking', [OrderController::class, 'advanceTracking']);

// 3. HADP Government Subsidies & DBT Beneficiary Portal
Route::get('hadp', [HadpApplicationController::class, 'index']);
Route::post('hadp', [HadpApplicationController::class, 'store']);
Route::get('hadp/{refNo}', [HadpApplicationController::class, 'show']);
Route::post('hadp/{refNo}/advance-stage', [HadpApplicationController::class, 'advanceStage']);

// 4. INAPH 12-Digit RFID Livestock Passports
Route::get('inaph', [InaphPassportController::class, 'index']);
Route::post('inaph', [InaphPassportController::class, 'store']);
Route::get('inaph/{tagNo}', [InaphPassportController::class, 'show']);

// 5. SKUAST-K Clinical Diagnostic Assistant & Drug Dosage
Route::post('clinical/diagnose', [ClinicalDiagnosisController::class, 'diagnose']);
Route::post('clinical/dosage', [ClinicalDiagnosisController::class, 'dosage']);

// 6. HADP Project 27 Wool Laboratory Analyzer
Route::get('wool-lab', [WoolLabController::class, 'index']);
Route::post('wool-lab/analyze', [WoolLabController::class, 'analyze']);
Route::get('wool-lab/{sampleCode}', [WoolLabController::class, 'show']);

// 7. Alpine Bahak Migration Transit Logger
Route::get('bahak-transit', [BahakTransitController::class, 'index']);
Route::post('bahak-transit', [BahakTransitController::class, 'store']);
