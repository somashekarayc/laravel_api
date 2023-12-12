<?php

use App\Http\Controllers\Api\V1\CustomerController;
use App\Http\Controllers\Api\V1\InvoiceController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::middleware('auth:sanctum')->prefix('v1')->namespace('App\Http\Controllers\Api\V1')->group(function () {

        Route::post('invoices/bulk', [InvoiceController::class, 'bulkStore']);
        Route::apiResource('customers', CustomerController::class);
        Route::apiResource('invoices', InvoiceController::class);

    });
