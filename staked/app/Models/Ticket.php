<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    //
    protected $fillable = [
        'ticket_number', 'date', 'total_stake', 'total_odds', 'total_return', 'status', 'user_id', 'notes','total_bonus'
    ];

    public function bets() {
        return $this->hasMany(Bet::class);
    }

    // In Ticket model (app/Models/Ticket.php)
    public function getProfitLossAttribute()
    {
        return ($this->total_return ?? 0) - ($this->total_stake ?? 0);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
        
    protected static function booted()
    {
        static::deleting(function ($ticket) {
            $ticket->bets()->delete();
        });
    }


    

}
