<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function wallets()
    {
        return $this->hasMany(Wallet::class);
    }

    public function contactedCandidates()
    {
        return $this->hasMany(ContactedCandidate::class);
    }

    public function hiredCandidates(){
        return $this->hasMany(HiredCandidate::class);
    }
}
