<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PlannedBet extends Model
{
    //
    protected $fillable = [
                        'home_team_id',
                        'away_team_id',
                        'user_id',
                        'prediction',
                        'odd',
                        'notes',
                        'match_date',
                        'status',
                    ];


    protected $casts = [
                        'match_date' => 'datetime',
                    ];
                
    public function homeTeam()
    {
        return $this->belongsTo(Team::class, 'home_team_id');
    }

    public function awayTeam()
    {
        return $this->belongsTo(Team::class, 'away_team_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }                

}
