<?php

namespace App\Http\Controllers\Candidate;

use App\Http\Controllers\Controller;
use App\Models\Candidate;
use App\Services\CandidateService;

class CandidateHireController extends Controller
{
    protected $candidateService;

    public function __construct(CandidateService $candidateService)
    {
        $this->candidateService = $candidateService;
    }

    public function __invoke(Candidate $candidate)
    {
        $companyId = 1;

        if ($this->candidateService->hireCandidate($companyId, $candidate)) {
            return back()->with('success', 'Candidate hired successfully');
        }

        return back()->withErrors(['errors', 'Unable to hire candidate']);
    }
}
