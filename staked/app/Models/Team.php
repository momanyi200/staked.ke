<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    protected $fillable = [
        'name',
        'country_id',
    ];

    public function country(){
        return $this->belongsTo(Country::class);
    }    

    public function homeBets()
    {
        return $this->hasMany(Bet::class, 'home_team_id');
    }

    public function awayBets()
    {
        return $this->hasMany(Bet::class, 'away_team_id');
    }

    public function allBets()
    {
        return $this->homeBets->merge($this->awayBets);
    }

    // app/Models/Team.php
    public function banned()
    {
        return $this->hasOne(BannedTeam::class);
    }


}