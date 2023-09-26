<?php

namespace App\Http\Controllers;

use App\Mail\Registration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class MailController extends Controller
{
  public function send()
  {
    $details = [
      'title' => 'My Test Mail',
      'body' => 'My Body for mail'
    ];

    Mail::to('adarshjose5430@gmail.com')->send(new MyMails($details));
    return 'Email Sent';
  }


  public function registrationOTP($email, $mobile, $name, $otp)
  {
    $details = [
      'otp' => $otp,
      'name' => $name
    ];

    Mail::to($email)->send(new Registration($details));



    return '{"sts":"01"}';
  }
}
