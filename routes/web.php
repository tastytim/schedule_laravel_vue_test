<?php

use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\MailController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
// GET APPOINTMENTS
Route::get('/appointments',  [AppointmentController::class, 'getAppointments']);
//ADD APPOINTMENTS
Route::post('/appointments', [AppointmentController::class, 'createAppointment']);
//DELETE APPOINTMENT
Route::delete('/appointments/{id}', [AppointmentController::class, 'deleteAppointment']);
Auth::routes();
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
// // Email Route
// Route::get('send-mail', [MailController::class, 'index']);