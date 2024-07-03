<?php


namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\User;


class ImageUploaded extends Mailable
{
    use Queueable, SerializesModels;

    public $email;
    public $filename;

    /**
     * Create a new message instance.
     *
     * @param string $email
     * @param string $filename
     */
    public function __construct($email, $filename)
    {
        $this->email = $email;
        $this->filename = $filename;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from($this->email, env('APP_NAME'))
                    ->subject('Customer Submitted an Image')
                    ->to(User::first()->email)  // Ensure the "To" address is correctly set
                    ->view('mail.image_upload_email')
                    ->with([
                        'email' => $this->email,
                        'filename' => $this->filename,
                    ]);
    }
}

