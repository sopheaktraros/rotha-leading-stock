<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendToClient extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $request;
    public function __construct($data) {
        $this->request = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from(env('MAIL_FROM_ADDRESS'),'Admin')
            ->to($this->request['email'])
            ->subject(__('Your enquiry for '.$this->request['book_type'].' has been received.'))
            ->view('website.grand-phnompenh.booking.mail-client');
    }
}
