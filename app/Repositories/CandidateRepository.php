<?php

namespace App\Repositories;

use App\Models\Candidate;
use App\Models\Company;

class CandidateRepository
{
    public function getCandidateEmailById($candidateId)
    {
        return Candidate::where('id', $candidateId)->value('email');
    }

    public function getCompanyNameByCompanyId($companyId)
    {
        return Company::where('id', $companyId)->value('name');
    }
}
