<?php

namespace App\Http\Controllers;

use App\Models\Candidate;
use App\Models\Company;
use App\Services\CandidateService;

class CandidateController extends Controller
{
    protected $candidateService;

    public function __construct(CandidateService $candidateService)
    {
        $this->candidateService = $candidateService;
    }

    public function index()
    {
        $candidates = Candidate::with(['contactedCompanies', 'hiredCompanies'])
        ->select(['id', 'name', 'description', 'strengths', 'soft_skills'])
        ->get()
        ->map(function ($candidate) {
            $candidate->contacted = $candidate->contactedCompanies->isNotEmpty();
            $candidate->hired = $candidate->hiredCompanies->isNotEmpty();
            return $candidate;
        });
        
        $coins = Company::find(1)->wallet->coins;
        return view('candidates.index', compact('candidates', 'coins'));
    }

    public function contact(Candidate $candidate)
    {
        $companyId = 1;

        if ($this->candidateService->contactCandidate($companyId, $candidate)) {
            return response()->json(['message' => 'Candidate contacted successfully']);
        }

        return response()->json(['message' => 'Unable to contact candidate'], 400);
    }

    public function hire(Candidate $candidate)
    {
        $companyId = 1;

        if($this->candidateService->hireCandidate($companyId, $candidate)){
            return response()->json(['message' => 'Candidate hired successfully']);
        }
        
        return response()->json(['message' => 'Unable to hire candidate'], 400);
    }
}
