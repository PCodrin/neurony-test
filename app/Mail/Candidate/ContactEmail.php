<?php

namespace App\Mail\Candidate;

use Illuminate\Mail\Mailable;

class ContactEmail extends Mailable
{
    public $companyName;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($companyName)
    {
        $this->companyName = $companyName;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Subject for Contact Email')->view('emails.contact');
    }
}
