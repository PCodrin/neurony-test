<?php

namespace App\Services;

use App\Repositories\CandidateRepository;
use App\Repositories\ContactedCandidateRepository;
use App\Repositories\WalletRepository;
use App\Services\CandidateEmailService;

class CandidateService
{
    protected $candidateRepository;
    protected $walletRepository;
    protected $contactedCandidateRepository;
    protected $candidateEmailService;

    public function __construct(
        CandidateRepository $candidateRepository,
        WalletRepository $walletRepository,
        ContactedCandidateRepository $contactedCandidateRepository,
        CandidateEmailService $candidateEmailService
    ) {
        $this->candidateRepository = $candidateRepository;
        $this->walletRepository = $walletRepository;
        $this->contactedCandidateRepository = $contactedCandidateRepository;
        $this->candidateEmailService = $candidateEmailService;
    }

    public function contactCandidate($companyId, $candidateId)
    {
        if (!$this->contactedCandidateRepository->hasBeenContacted($companyId, $candidateId)) {
            $companyWallet = $this->walletRepository->getWalletByCompanyId($companyId);
            $coinsRequired = 5;

            if ($companyWallet->coins >= $coinsRequired) {
                $this->walletRepository->withdrawCoins($companyId, $coinsRequired);

                $candidateEmail = $this->candidateRepository->getCandidateEmailById($candidateId);
                $companyName = $this->candidateRepository->getCompanyNameByCompanyId($companyId);

                $this->candidateEmailService->sendContactEmail($candidateEmail, $companyName);

                $this->contactedCandidateRepository->addContactedCandidate($companyId, $candidateId);

                return true;
            }
        }

        return false;
    }
}
