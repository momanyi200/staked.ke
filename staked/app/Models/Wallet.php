<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Wallet extends Model
{
    protected $fillable = ['balance', 'user_id'];

    public function transactions()
    {
        return $this->hasMany(WalletTransaction::class);
    }

    public function credit($amount, $type, $reference = null, $description = null)
    {
        $this->balance += $amount;
        $this->save();

        $this->transactions()->create([
            'type' => $type,
            'amount' => $amount,
            'reference' => $reference,
            'description' => $description,
        ]);
    }

    public function debit($amount, $type, $reference = null, $description = null)
    {
        if ($this->balance < $amount) {
            throw new \Exception("Insufficient balance");
        }

        $this->balance -= $amount;
        $this->save();

        $this->transactions()->create([
            'type' => $type,
            'amount' => -$amount,
            'reference' => $reference,
            'description' => $description,
        ]);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}

