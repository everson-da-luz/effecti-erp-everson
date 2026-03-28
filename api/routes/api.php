<?php

use App\Http\Controllers\ClientController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\ContractController;
use App\Http\Controllers\ContractItemController;
use Illuminate\Support\Facades\Route;

Route::apiResource('clients', ClientController::class);
Route::apiResource('services', ServiceController::class);
Route::apiResource('contracts', ContractController::class);

Route::post('/contracts/{contractId}/items', [ContractItemController::class, 'store']);
Route::delete('/contracts/items/{id}', [ContractItemController::class, 'destroy']);