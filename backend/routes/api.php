<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CustomerController;
use App\Http\Controllers\Api\DeviceController;
use App\Http\Controllers\Api\MeterReadingController;
use App\Http\Controllers\Api\BillingController;
use App\Http\Controllers\Api\AlertController;

Route::get('/health', function () {
    return response()->json(['status' => 'OK']);
});

Route::apiResource('customers', CustomerController::class);
Route::apiResource('devices', DeviceController::class);

// Meter Reading Routes
Route::post('meter-readings', [MeterReadingController::class, 'store']);
Route::get('devices/{id}/readings', [MeterReadingController::class, 'getReadingsByDevice']);

// Billing Routes
Route::get('customers/{id}/billing', [BillingController::class, 'getBillingByCustomer']);
Route::post('billing/generate', [BillingController::class, 'generate']);

// Alert Routes
Route::get('customers/{id}/alerts', [AlertController::class, 'getAlertsByCustomer']);
Route::post('alerts', [AlertController::class, 'store']);
Route::post('alerts/check-usage', [AlertController::class, 'checkUsage']);

// Additional route to get all devices for a specific customer by ID
Route::get('customers/{id}/devices', function ($id) {
    $customer = \App\Models\Customer::with('devices')->findOrFail($id);
    return response()->json($customer->devices);
});
