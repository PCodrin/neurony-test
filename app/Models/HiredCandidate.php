<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HiredCandidate extends Model
{
    protected $fillable = ['company_id', 'candidate_id'];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function candidate()
    {
        return $this->belongsTo(Candidate::class);
    }
}