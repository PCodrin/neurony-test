<?php

namespace App\Mail\Candidate;

use Illuminate\Mail\Mailable;

class HireEmail extends Mailable
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
        return $this->subject('Subject for Hire Email')->view('emails.hire');
    }
}
