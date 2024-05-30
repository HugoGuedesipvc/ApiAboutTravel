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

// Auth
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\LocalController;
use App\Http\Controllers\API\TripController;
use App\Http\Controllers\API\TripShareController;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\UserRatedLocalController;
use App\Http\Controllers\API\UserRatedTripController;
use App\Http\Controllers\API\UserSharedTripController;

Route::group(['prefix' => 'auth'], function () {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('refresh', [AuthController::class, 'refresh']);
    Route::get('me', [AuthController::class, 'me']);
    Route::post("Create_user", [UserController::class, 'store']);
});

Route::group(['middleware' => 'auth:api'], function () {
    Route::apiResource("trips", TripController::class);
    Route::apiResource("trips.locals", LocalController::class);
    Route::get("users/me", [UserController::class, 'me']);
    Route::apiResource("users", UserController::class);
    Route::apiResource("user-shared-trips", UserSharedTripController::class);
    Route::apiResource("trips.user-rating-trips", UserRatedTripController::class);
    Route::apiResource("trips.locals.user-rating-locals", UserRatedLocalController::class);
});
