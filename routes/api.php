<?php

use App\Http\Controllers\Api\AppointmentController as ApiAppointmentController;
use App\Http\Controllers\AppointmentController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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

Auth::routes();

// GET APPOINTMENTS
Route::get('/appointments',  [ApiAppointmentController::class, 'getAppointments']);
//ADD APPOINTMENTS
Route::post('/appointments', [ApiAppointmentController::class, 'createAppointment']);




