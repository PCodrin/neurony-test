<?php

use App\Models\Wallet;
use App\Repositories\WalletRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class WalletRepositoryTest extends TestCase
{
    use RefreshDatabase;

    public function testGetWalletByCompanyId()
    {
        $companyWallet = Wallet::factory()->create();
        $walletRepository = new WalletRepository();
        $result = $walletRepository->getWalletByCompanyId($companyWallet->company_id);

        $this->assertEquals($companyWallet->id, $result->id);
    }

    public function testHasEnoughCoins()
    {
        $companyWallet = Wallet::factory()->create(['coins' => 10]);
        $walletRepository = new WalletRepository();
        $result = $walletRepository->hasEnoughCoins($companyWallet->company_id, 5);

        $this->assertTrue($result);
    }

    public function testWithdrawCoins()
    {
        $companyWallet = Wallet::factory()->create(['coins' => 10]);
        $walletRepository = new WalletRepository();
        $walletRepository->withdrawCoins($companyWallet->company_id, 5);
        $companyWallet->refresh();

        $this->assertEquals(5, $companyWallet->coins);
    }

    public function testRefundCoins()
    {
        $companyWallet = Wallet::factory()->create(['coins' => 10]);
        $walletRepository = new WalletRepository();
        $walletRepository->refundCoins($companyWallet->company_id, 5);
        $companyWallet->refresh();

        $this->assertEquals(15, $companyWallet->coins);
    }
}
