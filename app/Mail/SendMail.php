<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\View;

class SendMail extends Mailable
{
    use Queueable, SerializesModels;

    public $email;

    public function __construct($email)
    {
        $this->email = $email;
    }


    /**
     * Build the message.
     */
    public function build()
    {
        return $this->subject('Registration Successful at Firequick')
                    ->view('mail.register_welcome_email');
    }
}
