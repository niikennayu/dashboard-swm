<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CustomerController;

Route::get('/health', function () {
    return response()->json(['status' => 'OK']);
});

Route::apiResource('customers', CustomerController::class);
