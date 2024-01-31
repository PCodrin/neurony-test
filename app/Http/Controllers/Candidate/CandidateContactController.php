<?php

namespace App\Http\Controllers\Candidate;

use App\Http\Controllers\Controller;
use App\Models\Candidate;
use App\Services\CandidateService;

class CandidateContactController extends Controller
{
    protected $candidateService;

    public function __construct(CandidateService $candidateService)
    {
        $this->candidateService = $candidateService;
    }

    public function __invoke(Candidate $candidate)
    {
        $companyId = 1;

        if ($this->candidateService->contactCandidate($companyId, $candidate)) {
            return back()->with('success', 'Candidate contacted successfully');
        }

        return back()->withErrors(['Unable to contact candidate']);
    }
}
