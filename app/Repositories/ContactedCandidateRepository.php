<?php

namespace App\Repositories;

use App\Models\ContactedCandidate;

class ContactedCandidateRepository
{
    public function addContactedCandidate($companyId, $candidateId)
    {
        ContactedCandidate::create([
            'company_id' => $companyId,
            'candidate_id' => $candidateId,
        ]);
    }

    public function hasBeenContacted($companyId, $candidateId)
    {
        return ContactedCandidate::where('company_id', $companyId)
            ->where('candidate_id', $candidateId)
            ->exists();
    }
}