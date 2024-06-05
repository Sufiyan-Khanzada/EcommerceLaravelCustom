<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Illuminate\Support\Facades\View;

class SendMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $name;
    protected $email;
    protected $comment;

    /**
     * Create a new message instance.
     */
    public function __construct($name, $email, $comment)
    {
        $this->name = $name;
        $this->email = $email;
        $this->comment = $comment;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        $mail = new PHPMailer(true);

        try {
            // Server settings
            $mail->SMTPDebug = 0; // Disable debug output
            $mail->isSMTP(); // Use SMTP
            $mail->Host = env('MAIL_HOST'); // Set the SMTP server to send through
            $mail->SMTPAuth = true; // Enable SMTP authentication
            $mail->Username = env('MAIL_USERNAME'); // SMTP username
            $mail->Password = env('MAIL_PASSWORD'); // SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Enable TLS encryption
            $mail->Port = env('MAIL_PORT'); // TCP port to connect to

            // Recipients
            $mail->setFrom(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'));
            $mail->addAddress($this->email, $this->name); // Add a recipient

            // Content
            $mail->isHTML(true); // Set email format to HTML
            $mail->Subject = 'Registration Successful at Firequick';
            $mail->Body = View::make('mail.register_welcome_email', [
                'name' => $this->name,
                'email' => $this->email,
                'comment' => $this->comment,
            ])->render();
            $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

            $mail->send();
            echo 'Message has been sent';
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    }
}
