<?php

use App\Services\CandidateEmailService;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class CandidateEmailServiceTest extends TestCase
{
    public function testSendContactEmail()
    {
        Mail::fake();
        $candidateEmail = 'test@neurony.ro';
        $companyName = 'Neurony';
        $emailService = new CandidateEmailService();

        $result = $emailService->sendContactEmail($candidateEmail, $companyName);

        Mail::assertSent(\App\Mail\Candidate\ContactEmail::class, function ($mail) use ($candidateEmail, $companyName) {
            return $mail->hasTo($candidateEmail) && $mail->companyName === $companyName;
        });

        $this->assertTrue($result);
    }

    public function testSendHireEmail()
    {
        Mail::fake();
        $candidateEmail = 'test@neurony.ro';
        $companyName = 'Neurony';
        $emailService = new CandidateEmailService();

        $result = $emailService->sendHireEmail($candidateEmail, $companyName);

        Mail::assertSent(\App\Mail\Candidate\HireEmail::class, function ($mail) use ($candidateEmail, $companyName) {
            return $mail->hasTo($candidateEmail) && $mail->companyName === $companyName;
        });

        $this->assertTrue($result);
    }
}
