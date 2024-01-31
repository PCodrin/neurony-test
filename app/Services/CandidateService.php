<?php

namespace App\Services;

use App\Repositories\CandidateRepository;
use App\Repositories\ContactedCandidateRepository;
use App\Repositories\HiredCandidateRepository;
use App\Repositories\WalletRepository;
use App\Services\CandidateEmailService;

class CandidateService
{
    protected const COINS_REQUIRED_CONTACT = 5;
    protected const COINS_TO_BE_REFUNDED = 5;

    protected $candidateRepository;
    protected $walletRepository;
    protected $contactedCandidateRepository;
    protected $hiredCandidateRepository;
    protected $candidateEmailService;

    public function __construct(
        CandidateRepository $candidateRepository,
        WalletRepository $walletRepository,
        ContactedCandidateRepository $contactedCandidateRepository,
        HiredCandidateRepository $hiredCandidateRepository,
        CandidateEmailService $candidateEmailService
    ) {
        $this->candidateRepository = $candidateRepository;
        $this->walletRepository = $walletRepository;
        $this->contactedCandidateRepository = $contactedCandidateRepository;
        $this->hiredCandidateRepository = $hiredCandidateRepository;
        $this->candidateEmailService = $candidateEmailService;
    }

    public function contactCandidate($companyId, $candidate)
    {
        if (!$this->candidateRepository->getCandidateById($candidate->id)) {
            return false;
        }

        $coinsRequired = self::COINS_REQUIRED_CONTACT;

        if ($this->walletRepository->hasEnoughCoins($companyId, $coinsRequired)) {
            $this->walletRepository->withdrawCoins($companyId, $coinsRequired);

            $this->contactedCandidateRepository->addContactedCandidate($companyId, $candidate->id);

            $this->sendEmail('contact', $companyId, $candidate);

            return true;
        }

        return false;
    }

    public function hireCandidate($companyId, $candidate)
    {
        if (!$this->candidateRepository->getCandidateById($candidate->id)) {
            return false;
        }

        if (!$this->contactedCandidateRepository->hasBeenContacted($companyId, $candidate->id)) {
            return false;
        }

        if ($this->hiredCandidateRepository->hasBeenHired($candidate->id)) {
            return false;
        }

        $coinsToBeRefunded = self::COINS_TO_BE_REFUNDED;

        $this->hiredCandidateRepository->addHiredCandidate($companyId, $candidate->id);

        $this->walletRepository->refundCoins($companyId, $coinsToBeRefunded);

        $this->sendEmail('hire', $companyId, $candidate);

        return true;
    }

    protected function sendEmail($type, $companyId, $candidate)
    {
        $candidateEmail = $this->candidateRepository->getCandidateEmailById($candidate->id);
        $companyName = $this->candidateRepository->getCompanyNameByCompanyId($companyId);

        if ($type === 'contact') {
            $this->candidateEmailService->sendContactEmail($candidateEmail, $companyName);
        } elseif ($type === 'hire') {
            $this->candidateEmailService->sendHireEmail($candidateEmail, $companyName);
        }
    }
}
