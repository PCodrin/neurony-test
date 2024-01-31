<?php

namespace App\Mail\Candidate;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class HireEmail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;
    
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
