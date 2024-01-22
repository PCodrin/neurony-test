<?php

use App\Interfaces\CandidateMailerInterface;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class CandidateEmailService implements CandidateMailerInterface
{
    public function sendContactEmail($candidateEmail, $companyName)
    {
        try {
            Mail::to($candidateEmail)->send(new \App\Mail\Candidate\ContactEmail($companyName));
            return true;
        } catch (\Exception $e) {
            Log::error('Error sending contact email: ' . $e->getMessage());
            return false;
        }
    }

    public function sendHireEmail($candidateEmail, $companyName)
    {
        try {
            Mail::to($candidateEmail)->send(new \App\Mail\Candidate\HireEmail($companyName));
            return true;
        } catch (\Exception $e) {
            Log::error('Error sending hire email: ' . $e->getMessage());
            return false;
        }
    }
}
