<?php

namespace App\Repositories;

use App\Models\HiredCandidate;

class HiredCandidateRepository
{
    public function addHiredCandidate($companyId, $candidateId)
    {
        HiredCandidate::create([
            'company_id' => $companyId,
            'candidate_id' => $candidateId,
        ]);
    }

    public function hasBeenHired($candidateId)
    {
        return HiredCandidate::where('candidate_id', $candidateId)->exists();
    }
}