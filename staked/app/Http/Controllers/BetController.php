<?php

namespace App\Http\Controllers;

use App\Models\Bet;
use App\Services\TeamValidator;
use Illuminate\Http\Request;

class BetController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'team' => 'required|string|max:255',
            'amount' => 'required|numeric|min:10',
        ]);

        // Check if team is banned
        $banned = TeamValidator::isBanned($request->team);
        if ($banned) {
            return back()->withErrors([
                'team' => "⚠ The team '{$banned->name}' is banned. Reason: {$banned->reason}"
            ])->withInput();
        }

        // Otherwise save the bet
        Bet::create([
            'user_id' => auth()->id(),
            'team' => $request->team,
            'amount' => $request->amount,
        ]);

        return redirect()->route('bets.index')->with('success', 'Bet placed successfully!');
    }
}
