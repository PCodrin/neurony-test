<?php

use App\Services\CandidateService;
use App\Repositories\CandidateRepository;
use App\Repositories\WalletRepository;
use App\Repositories\ContactedCandidateRepository;
use App\Repositories\HiredCandidateRepository;
use App\Services\CandidateEmailService;
use Tests\TestCase;

class CandidateServiceTest extends TestCase
{
    public function testContactCandidate()
    {
        $candidateRepository = $this->getMockBuilder(CandidateRepository::class)->getMock();
        $walletRepository = $this->getMockBuilder(WalletRepository::class)->getMock();
        $contactedCandidateRepository = $this->getMockBuilder(ContactedCandidateRepository::class)->getMock();
        $hiredCandidateRepository = $this->getMockBuilder(HiredCandidateRepository::class)->getMock();
        $candidateEmailService = $this->getMockBuilder(CandidateEmailService::class)->getMock();

        $candidateService = new CandidateService(
            $candidateRepository,
            $walletRepository,
            $contactedCandidateRepository,
            $hiredCandidateRepository,
            $candidateEmailService
        );

        $companyId = 1;
        $candidate = (object)['id' => 1];

        $walletRepository->expects($this->once())->method('hasEnoughCoins')->willReturn(true);
        $walletRepository->expects($this->once())->method('withdrawCoins');
        $contactedCandidateRepository->expects($this->once())->method('hasBeenContacted')->willReturn(false);
        $candidateRepository->expects($this->once())->method('getCandidateById')->willReturn($candidate);
        $candidateEmailService->expects($this->once())->method('sendContactEmail');

        $result = $candidateService->contactCandidate($companyId, $candidate);

        $this->assertTrue($result);
    }

    public function testHireCandidate()
    {
        $candidateRepository = $this->getMockBuilder(CandidateRepository::class)->getMock();
        $walletRepository = $this->getMockBuilder(WalletRepository::class)->getMock();
        $contactedCandidateRepository = $this->getMockBuilder(ContactedCandidateRepository::class)->getMock();
        $hiredCandidateRepository = $this->getMockBuilder(HiredCandidateRepository::class)->getMock();
        $candidateEmailService = $this->getMockBuilder(CandidateEmailService::class)->getMock();

        $candidateService = new CandidateService(
            $candidateRepository,
            $walletRepository,
            $contactedCandidateRepository,
            $hiredCandidateRepository,
            $candidateEmailService
        );

        $companyId = 1;
        $candidate = (object)['id' => 1];

        $hiredCandidateRepository->expects($this->once())->method('hasBeenHired')->willReturn(false);
        $contactedCandidateRepository->expects($this->once())->method('hasBeenContacted')->willReturn(true);
        $candidateRepository->expects($this->once())->method('getCandidateById')->willReturn($candidate);
        $hiredCandidateRepository->expects($this->once())->method('addHiredCandidate');
        $walletRepository->expects($this->once())->method('refundCoins');
        $candidateEmailService->expects($this->once())->method('sendHireEmail');
       
        $result = $candidateService->hireCandidate($companyId, $candidate);

        $this->assertTrue($result);
    }
}
