<?php


namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewCustomerNotificationAdmin extends Mailable
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
        return $this->subject('New User Registered')
                    ->view('mail.register_welcome_email_admin');
    }

}
