<?php

namespace App\Http\Controllers;

use App\Models\BannedTeam;
use App\Models\Team;
use Illuminate\Http\Request;

class BannedTeamController extends Controller
{
    public function index()
    {
         $teams = BannedTeam::with('team')->latest()->paginate(10);
        return view('backend.banned-teams.index', compact('teams'));
    }

    public function create()
    {
        $teams=Team::with('country')->get();
        return view('backend.banned-teams.create',compact('teams'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'team_id' => 'required|string|unique:banned_teams,id|max:255',
            'reason' => 'nullable|string|max:500',
        ]);

        BannedTeam::create($request->only('team_id', 'reason'));

        return redirect()->route('banned-teams.index')
            ->with('success', 'Team banned successfully!');
    }

    public function destroy(BannedTeam $bannedTeam)
    {
        $bannedTeam->delete();
        return redirect()->route('banned-teams.index')
            ->with('success', 'Team removed from banned list.');
    }
}
