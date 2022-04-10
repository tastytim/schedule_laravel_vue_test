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
        
        $appointment = new Appointment();
        $appointment->user_id = 2;
        $appointment->description = $request->description;
        $appointment->url = $request->url;
        $appointment->date_start = $request->date_start;
        $appointment->date_end = $request->date_end;
        $appointment->is_all_day = $request->is_all_day;
        $appointment->is_notificate = $request->is_notificate;
        $appointment->save();


        return response('Ok', 200);
    }
}
