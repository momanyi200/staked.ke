<?php

// app/Models/Journal.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Journal extends Model
{
    protected $fillable = ['date', 'user_id', 'summary', 'thoughts'];

    protected $casts = [
        'date' => 'date',   // 👈 this makes $journal->date a Carbon instance
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

