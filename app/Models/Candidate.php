<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Candidate extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'email'];

    public function contactedCompanies()
    {
        return $this->belongsToMany(Company::class, 'contacted_candidates', 'candidate_id', 'company_id');
    }

    public function hiredCompanies()
    {
        return $this->belongsToMany(Company::class, 'hired_candidates', 'candidate_id', 'company_id');
    }
}