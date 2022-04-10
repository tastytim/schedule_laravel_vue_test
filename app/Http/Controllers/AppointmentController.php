<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Emails;
use GuzzleHttp\Psr7\Response;
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
        $request->validate([
            "description" => 'required',
            "url" => 'required',
            "date_start" => 'required',
            "date_end" => 'required',
            "emails" => 'required',
        ]);

        $appointment = new Appointment();
        $appointment->user_id = Auth::id();
        $appointment->description = $request->description;
        $appointment->url = $request->url;
        $appointment->date_start = $request->date_start;
        $appointment->date_end = $request->date_end;
        $appointment->is_all_day = $request->is_all_day;
        $appointment->is_notificate = $request->is_notificate;
        $appointment->save();

        foreach($appointment->email as $email){
           $newEmail = new Emails();
           $newEmail->appointment_id = $appointment->id;
           $newEmail->email = $email['email'];
           $appointment->email()->save($newEmail);
        }

        return response('Ok',200);
    }
}
