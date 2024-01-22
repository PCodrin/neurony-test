<?php

namespace App\Repositories;

use App\Models\HiredCandidate;

class HiredCandidateRepository
{
    public function addHiredCandidate($candidateId)
    {
        HiredCandidate::create([
            'candidate_id' => $candidateId,
        ]);
    }

    public function isCandidateHired($candidateId)
    {
        return HiredCandidate::where('candidate_id', $candidateId)->exists();
    }
}