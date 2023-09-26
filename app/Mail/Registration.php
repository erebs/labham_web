<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Registration extends Mailable
{
    use Queueable, SerializesModels;

    public $details;


    public function __construct($details)
    {
      $this->details = $details; 
    }

    public function build()
    {
      return $this->subject('Your VioSmart Verification Code is '.$this->details['otp'])->view('emails.registration');
    }
}
