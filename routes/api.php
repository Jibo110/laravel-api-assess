<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\GoogleAuthController;



/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResource('users', UserController::class);
Route::apiResource('products', ProductController::class);
Route::apiResource('orders', OrderController::class);


Route::get('/google/redirect', [GoogleAuthController::class, 'redirectToGoogle']);
Route::get('/google/callback', [GoogleAuthController::class, 'handleGoogleCallback']);



Route::post('/lighthouse/performance', [LighthouseController::class, 'getPerformanceScore']);

