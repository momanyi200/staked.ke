<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class BannedTeam extends Model
{
    use HasFactory;

    protected $fillable = ['team_id', 'reason'];
    public function team()
    {
        return $this->belongsTo(Team::class);
    }
}
