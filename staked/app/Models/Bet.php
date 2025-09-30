<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bet extends Model
{
    //
    protected $fillable = [
        'ticket_id', 'home_team_id', 'away_team_id', 'bet_type', 'odds', 'result'
    ];

    public function ticket() {
        return $this->belongsTo(Ticket::class);
    }

    public function homeTeam()
    {
        return $this->belongsTo(Team::class, 'home_team_id');
    }

    public function awayTeam()
    {
        return $this->belongsTo(Team::class, 'away_team_id');
    }


}
