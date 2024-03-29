<?php

namespace App\Repositories;

use App\Models\Wallet;

class WalletRepository
{
    public function getWalletByCompanyId($companyId)
    {
        return Wallet::where('company_id', $companyId)->first();
    }
    
    public function hasEnoughCoins($companyId, $amount)
    {
        $companyWallet = Wallet::where('company_id', $companyId)->first();

        return $companyWallet && $companyWallet->coins >= $amount;
    }

    public function withdrawCoins($companyId, $amount)
    {
        $wallet = $this->getWalletByCompanyId($companyId);

        if ($wallet) {
            $wallet->decrement('coins', $amount);
        }
    }

    public function refundCoins($companyId, $amount)
    {
        $wallet = $this->getWalletByCompanyId($companyId);

        if ($wallet) {
            $wallet->increment('coins', $amount);
        }
    }
}
