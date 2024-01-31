<?php

namespace App\Http\Controllers\Candidate;

use App\Http\Controllers\Controller;
use App\Models\Candidate;
use App\Models\Company;
use Inertia\Inertia;
use Inertia\Response;

class CandidateController extends Controller
{
    public function __invoke(): Response
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

        return Inertia::render('Candidates/Index', [
            'candidates' => $candidates,
            'coins' => $coins
        ]);
    }
}
