<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\FlightController;
use App\Http\Controllers\Api\ReservationController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\creditCardController;
use App\Http\Controllers\Api\DashboardController;
use App\Http\Controllers\Api\NotificationsController;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::get('/' , function () {
    return 'Hello';
});

//flights API

Route::apiResource('flights', FlightController::class);
Route::get('flights/show/{id}', [FlightController::class , 'show']);

//login & signup API

Route::post('users/store', [UserController::class,'store']);
Route::post('users/show', [UserController::class,'show']);

//reservations API

Route::get('users/reservations/{id}', [UserController::class,'userReservations']);
Route::get('reservations', [ReservationController::class , 'index']);
Route::post('reservations/store', [ReservationController::class , 'store']);
Route::post('reservations/show', [ReservationController::class , 'show']);
Route::delete('reservations/destroy/{id}', [ReservationController::class , 'destroy']);

//credit cards API

Route::get('creditcards', [creditCardController::class , 'index']);
Route::post('creditcards/show', [creditCardController::class , 'show']);

//notifications API

Route::controller(NotificationsController::class)->group(function () {
    Route::get("/notifications/{user_id}" , "geUserNotifications");
    Route::get("/notifications/{user_id}/count" , "getUserNotificationsCount");
    Route::get("/notifications/{user_id}/change" , "changeNotificationStatus");
    Route::post("/notifications" , "addNotification");
});


//Dashboard API
Route::controller(DashboardController::class)->group(function () {
    Route::get("/dashboard/{user_id}/count" , "numberBooks");
    Route::get("/dashboard/{user_id}/total" , "moneySpending");
});
