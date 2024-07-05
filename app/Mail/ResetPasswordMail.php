<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ResetPasswordMail extends Mailable
{
    use Queueable, SerializesModels;

    public $email;
    public $token;

    public function __construct($email,$token)
    {
        $this->email = $email;
        $this->token = $token;
    }


    /**
     * Build the message.
     */
    public function build()
    {
        

                return $this->view('mail.reset_password')
                ->subject('Password Reset Firequick')
                ->with([
                    'token' => $this->token,
                    'email' => $this->email,
                ]);
    }

}
