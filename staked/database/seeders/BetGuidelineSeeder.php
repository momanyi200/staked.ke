<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\BetGuideline;

class BetGuidelineSeeder extends Seeder
{
    public function run(): void
    {
        $guidelines = [
            // Routines
            ['type' => 'routine', 'title' => 'Research the Match', 'description' => 'Check team form, lineup, motivation, and injuries.'],
            ['type' => 'routine', 'title' => 'Review Odds', 'description' => 'Compare odds across multiple bookies and monitor movements.'],
            ['type' => 'routine', 'title' => 'Analyze Stats', 'description' => 'Review H2H, goal averages, and home/away performance.'],
            ['type' => 'routine', 'title' => 'Confirm Bankroll', 'description' => 'Use only 1–5% of bankroll per bet.'],
            ['type' => 'routine', 'title' => 'Pause Before Confirming', 'description' => 'Take 5 minutes to reflect before placing the bet.'],

            // Rules
            ['type' => 'rule', 'title' => 'Avoid Emotional Betting', 'description' => 'Never bet after a loss or when emotional.'],
            ['type' => 'rule', 'title' => 'Stick to Your Plan', 'description' => 'Use consistent stake sizes and don’t chase losses.'],
            ['type' => 'rule', 'title' => 'Bet Only on Familiar Markets', 'description' => 'Avoid leagues or sports you don’t understand.'],
            ['type' => 'rule', 'title' => 'Limit Bets per Day', 'description' => 'Maximum 3 bets daily; review weekly.'],
            ['type' => 'rule', 'title' => 'Take Breaks on Losing Streaks', 'description' => 'Stop betting and analyze when 5 losses occur in a row.'],
        ];

        foreach ($guidelines as $g) {
            BetGuideline::create($g);
        }
    }
}
