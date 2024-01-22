<?php

namespace App\Interfaces;

interface CandidateMailerInterface {
    public function sendContactEmail($candidateEmail, $companyName);
    public function sendHireEmail($candidateEmail, $companyName);
}