<?php

namespace App\Services;

use App\Models\BannedTeam;

class TeamValidator
{
    public static function isBanned(string $teamName): ?BannedTeam
    {
        return BannedTeam::whereRaw('LOWER(name) = ?', [strtolower($teamName)])->first();
    }
}
