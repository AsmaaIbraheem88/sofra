<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ContactUs extends Mailable
{
    use Queueable, SerializesModels;

     private  $contact;

    /**
     * Create a new message instance.
     *
     * @param $contact
     */
    public function __construct( $contact)
    {
        $this->contact =  $contact;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.contact',['contact' => $this->contact]);
    }
}
