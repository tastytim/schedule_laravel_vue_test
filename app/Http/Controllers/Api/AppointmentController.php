<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AppointmentController extends Controller
{
    // GET APPOINTMENTS
    public function getAppointments(Request $request)
    {
        $user = Auth::id();
        $appointments = Appointment::where('id', $user)->with('emails')->get();
        return $appointments;
    }

   //CREATE NEW APPOINTMENT
    public function createAppointment(Request $request)
    {
    
    }
}
