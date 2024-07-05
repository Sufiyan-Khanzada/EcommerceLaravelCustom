<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendMail extends Mailable
{
    use Queueable, SerializesModels;

    public $email;
    public $fname;
    public $lname;

    public function __construct($email, $fname, $lname)
    {
        $this->email = $email;
        $this->fname = $fname;
        $this->lname = $lname;
    }

    public function build()
    {
        return $this->subject('Registration Successful at Firequick')
                    ->view('mail.register_welcome_email');
    }

}
