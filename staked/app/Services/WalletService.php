<?php

namespace App\Services;

use App\Models\Wallet;
use App\Models\WalletTransaction;
use Illuminate\Support\Facades\DB;
use Exception;
use Auth;

class WalletService
{
    protected function getWallet(): Wallet
    {
        return Wallet::where('user_id',Auth::user()->id)->firstOrCreate([], ['balance' => 0]);
    }

    public function getBalance()
    {
        $wallet = $this->getWallet();
        return $wallet->balance;
    }

    public function getTransactions()
    {
        return WalletTransaction::where('user_id',Auth::user()->id)->latest()->paginate(15);
    }


    public function deposit(float $amount, ?string $reference = null, ?string $description = null): Wallet
    {
        return DB::transaction(function () use ($amount, $reference, $description) {
            $wallet = $this->getWallet();
            $wallet->balance += $amount;
            $wallet->save();

            WalletTransaction::create([
                'user_id' => Auth::user()->id,
                'wallet_id'   => $wallet->id,
                'type'        => 'deposit',
                'amount'      => $amount,
                'reference'   => $reference,
                'description' => $description,
            ]);

            return $wallet;
        });
    }

    public function withdraw(float $amount, ?string $reference = null, ?string $description = null): Wallet
    {
        return DB::transaction(function () use ($amount, $reference, $description) {
            $wallet = $this->getWallet();

            if ($wallet->balance < $amount) {
                throw new Exception("Insufficient balance.");
            }

            $wallet->balance -= $amount;
            $wallet->save();

            WalletTransaction::create([
                'user_id' => Auth::user()->id,
                'wallet_id'   => $wallet->id,
                'type'        => 'withdrawal',
                'amount'      => $amount,
                'reference'   => $reference,
                'description' => $description,
            ]);

            return $wallet;
        });
    }

    public function stake(float $amount, string $ticketNo): Wallet
    {
        return DB::transaction(function () use ($amount, $ticketNo) {
            $wallet = $this->getWallet();

            if ($wallet->balance < $amount) {
                throw new Exception("Insufficient balance to place stake.");
            }

            $wallet->balance -= $amount;
            $wallet->save();

            WalletTransaction::create([
                'user_id' => Auth::user()->id,
                'wallet_id'   => $wallet->id,
                'type'        => 'stake',
                'amount'      => $amount,
                'reference'   => $ticketNo,
                'description' => "Stake placed on ticket #{$ticketNo}",
            ]);

            return $wallet;
        });
    }

    public function returnStake(float $amount, string $ticketNo): Wallet
    {
        return DB::transaction(function () use ($amount, $ticketNo) {
            $wallet = $this->getWallet();
            $wallet->balance += $amount;
            $wallet->save();

            WalletTransaction::create([
                'user_id' => Auth::user()->id,
                'wallet_id'   => $wallet->id,
                'type'        => 'return',
                'amount'      => $amount,
                'reference'   => $ticketNo,
                'description' => "Return for ticket #{$ticketNo}",
            ]);

            return $wallet;
        });
    }
}
