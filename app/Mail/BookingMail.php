<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Http\Request;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class BookingMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $request;
    public $bookTypeEmail;
    public function __construct($data,$bookTypeEmails) {
        $this->request = $data;
        $this->bookTypeEmail = $bookTypeEmails;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from($this->request['email'],$this->request['name'])
            ->to(explode(',',$this->bookTypeEmail))
            ->subject(__('New Booking From Customer'))
            ->view('website.grand-phnompenh.booking.mail');
    }
}
