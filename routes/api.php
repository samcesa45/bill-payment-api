<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::name('api.')->prefix('v1')->group(function(){
    Route::resource('users',App\Http\Controllers\UserController::class);
    Route::resource('transactions',App\Http\Controllers\TransactionController::class);
    Route::middleware('auth:sanctum')->group(function () {
        

    });

});