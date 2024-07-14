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
    public $states;

   

    public function __construct($orderItems,$orders,$dateInLocal,$customers,$states)
    {
        $this->orderItems = $orderItems;
        $this->orders = $orders;
       $this->dateInLocal=$dateInLocal;
       $this->customers=$customers;
       $this->states=$states;
       
    }

    public function build()
    {
        return $this->subject('New Order Received')
                    ->view('mail.InvoiceAdmin');
    }

    
}
