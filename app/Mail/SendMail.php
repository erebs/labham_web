<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Str;

class SendMail extends Mailable
{
    use Queueable, SerializesModels;
    public $mail;
    public $url;

    public function __construct($mail)
    {
        $this->mail = $mail;
        $this->url = url('/admin/change/'.base64_encode($mail));
    }

    public function build()
    {
        return $this->subject('Reset Password')->view('admin.mail.sendmail');
    }
}
