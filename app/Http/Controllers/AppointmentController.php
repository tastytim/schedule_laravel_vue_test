<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Emails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AppointmentController extends Controller
{
    // GET APPOINTMENTS
    public function getAppointments(Request $request)
    {
        $appointments = Appointment::where('user_id', Auth::id())->with('emails')->get();
        return $appointments;
    }

    //CREATE NEW APPOINTMENT
    public function createAppointment(Request $request)
    {
        // $request->validate([
        //     "description" => 'required',
        //     "url" => 'required',
        //     "date_start" => 'required',
        //     "date_end" => 'required',
        //     "emails" => 'required',
        // ]);   

        $appointment = new Appointment([
            'user_id' => Auth::id(),
            'description' => $request->input('description'),
            'url' => $request->input('url'),
            'date_start' => $request->input('date_start'),
            'date_end' => $request->input('date_end'),
            'is_all_day' => $request->input('is_all_day'),
            'is_notificate' => 0,
        ]);
        $appointment->save();

        // GET ID FROM CREATED APPOINTMENT
        $appointment_id = $appointment->id;

        //CREATE EMAILS
        $emails = explode(',', $request->emails);
        foreach ($emails as $value) {
            Emails::create([
                'email' => trim($value),
                'appointment_id' => $appointment_id,
            ]);
        }

        return response('Appointment created!', 200);
    }
}
