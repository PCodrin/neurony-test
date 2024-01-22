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
        $candidates = Candidate::all();
        $coins = Company::find(1)->coins;
        return view('candidates.index', compact('candidates', 'coins'));
    }

    public function contact(Candidate $candidate)
    {
        $companyId = 1;

        if ($this->candidateService->contactCandidate($companyId, $candidate->id)) {
            return response()->json(['message' => 'Candidate contacted successfully']);
        }

        return response()->json(['message' => 'Unable to contact candidate'], 400);
    }

    public function hire()
    {
        // @todo
        // Your code goes here...
    }
}
