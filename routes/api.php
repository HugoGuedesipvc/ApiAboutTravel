<?php

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

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\HomeController;
use App\Http\Controllers\API\LocalController;
use App\Http\Controllers\API\TripController;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\UserRatedLocalController;
use App\Http\Controllers\API\UserRatedTripController;
use App\Http\Controllers\API\UserSharedTripController;

Route::apiResource("home", HomeController::class)->only(['index']);

Route::group(['prefix' => 'auth'], function () {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('refresh', [AuthController::class, 'refresh']);
    Route::get('me', [AuthController::class, 'me']);
    Route::post('register', [AuthController::class, 'register']);
    Route::patch('update', [AuthController::class, 'update']);
    Route::delete('destroy', [AuthController::class, 'destroy']);
});

Route::group(['middleware' => 'auth:api'], function () {
    Route::apiResource("trips", TripController::class);
    Route::apiResource("trips.locals", LocalController::class);
    Route::apiResource("users", UserController::class)->except(['store']);
    Route::apiResource("user-shared-trips", UserSharedTripController::class)->except(['show', 'update']);
    Route::apiResource("trips.user-rating-trips", UserRatedTripController::class)->except(['index', 'show']);
    Route::apiResource("trips.locals.user-rating-locals", UserRatedLocalController::class)->except(['index', 'show']);
});
