<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\PlannedBet;

class ExpireOldPlannedBets extends Command
{
    protected $signature = 'plannedbets:expire';
    protected $description = 'Mark old planned bets as expired if their match date has passed.';

    public function handle()
    {
        $count = PlannedBet::where('status', '!=', 'decided')
            ->where('status', '!=', 'discarded')
            ->where('match_date', '<', now())
            ->update(['status' => 'expired']);

        $this->info("✅ $count planned bets marked as expired.");
    }
}
