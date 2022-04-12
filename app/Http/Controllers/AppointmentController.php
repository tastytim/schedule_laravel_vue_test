<?php

namespace App\Http\Controllers;

use App\Jobs\SendEmailJob;
use App\Mail\AppEmail;
use App\Models\Appointment;
use App\Models\Emails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

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


        // users a quali spedire
        $sendToUsers = [];


        //CREATE EMAILS
        $emails = explode(',', $request->emails);
        foreach ($emails as $value) {
            array_push($sendToUsers, trim($value));
            Emails::create([
                'email' => trim($value),
                'appointment_id' => $appointment_id,
            ]);
        }



        // SEND EMAILS ONE HOUR BEFORE
        foreach ($sendToUsers as $recipient) {
            // ONE MINUTE AFTER CREATE APPOINTMENT
            Mail::to($recipient)->later(now()->addMinutes(1), new AppEmail($appointment->url));
            // ONE HOUR BEFORE APPOINTMENT
            // Mail::to($recipient)->later(Carbon::instance($appointment->date_start)->subHours(1), new AppEmail($appointment->url));
        }




        return response('Appointment created!', 200);
    }



    // DELETE APPOINTMENT AND RELATIVE EMAILS
    public function deleteAppointment($id)
    {
        $appointment = Appointment::find($id);
        $appointment->emails()->delete();
        $appointment->delete();


        return response('Appointment deleted!', 200);
    }
}
