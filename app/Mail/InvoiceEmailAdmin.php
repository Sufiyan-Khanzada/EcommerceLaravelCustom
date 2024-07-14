<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class InvoiceEmailAdmin extends Mailable
{
    use Queueable, SerializesModels;



    public $orderItems;
    public $orders;
    public $dateInLocal;
    public $customers;
   

    public function __construct($orderItems,$orders,$dateInLocal,$customers)
    {
        $this->orderItems = $orderItems;
        $this->orders = $orders;
       $this->dateInLocal=$dateInLocal;
       $this->customers=$customers;
    }

    public function build()
    {
        return $this->subject('New Order Received')
                    ->view('mail.InvoiceAdmin');
    }

    
}
