<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CustomerController;
use App\Http\Controllers\Api\DeviceController;
use App\Http\Controllers\Api\MeterReadingController;

Route::get('/health', function () {
    return response()->json(['status' => 'OK']);
});

Route::apiResource('customers', CustomerController::class);
Route::apiResource('devices', DeviceController::class);
Route::post('meter-readings', [MeterReadingController::class, 'store']);
Route::get('devices/{id}/readings', [MeterReadingController::class, 'getReadingsByDevice']);

// Additional route to get all devices for a specific customer by ID
Route::get('customers/{id}/devices', function ($id) {
    $customer = \App\Models\Customer::with('devices')->findOrFail($id);
    return response()->json($customer->devices);
});
