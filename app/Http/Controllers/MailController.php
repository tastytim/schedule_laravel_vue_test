<?php

namespace App\Http\Controllers;

use App\Mail\AppEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class MailController extends Controller
{

    public function index(){
       $mailData = [

        'title' => 'Mail from Idra Technology',
        'body' => 'This is for testing email using smtp.'

    ];

     

    Mail::to('tastytimgm@gmail.com')->send(new AppEmail($mailData));

    dd("Email is sent successfully.");
    }
    
}
