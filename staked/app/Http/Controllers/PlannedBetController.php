<?php

namespace App\Http\Controllers;

use App\Models\PlannedBet;
use App\Models\Team;
use App\Models\BannedTeam;
use Illuminate\Http\Request;

class PlannedBetController extends Controller
{
    /**
     * Display a listing of planned bets.
     */
   
    public function index(Request $request)
    {
        // Auto-mark expired on page load — efficient, scoped to recent dates
        PlannedBet::whereNotIn('status', ['decided', 'discarded', 'expired'])
            ->where('match_date', '<', now())
            ->update(['status' => 'expired']);

        // Filtering logic
        $query = PlannedBet::with(['homeTeam', 'awayTeam']);

        if ($search = $request->input('search')) {
            $query->where(function($q) use ($search) {
                $q->whereHas('homeTeam', fn($q2) => $q2->where('name', 'like', "%{$search}%"))
                ->orWhereHas('awayTeam', fn($q2) => $q2->where('name', 'like', "%{$search}%"))
                ->orWhere('prediction', 'like', "%{$search}%");
            });
        }

        if ($status = $request->input('status')) {
            $query->where('status', $status);
        }

        if ($from = $request->input('from')) {
            $query->whereDate('match_date', '>=', $from);
        }

        if ($to = $request->input('to')) {
            $query->whereDate('match_date', '<=', $to);
        }

        $plannedBets = $query->orderByDesc('match_date')->get();

        return view('backend.planned_bets.index', compact('plannedBets'));
    }


    /**
     * Show the form for creating a new planned bet.
     */
    public function create()
    {
        $teams = Team::orderBy('name')->get();
        return view('backend.planned_bets.create', compact('teams'));
    }

    /**
     * Store a newly created planned bet.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'home_team_id' => 'required|exists:teams,id',
            'away_team_id' => 'required|exists:teams,id|different:home_team_id',
            'prediction'   => 'nullable|string|max:255',
            'odd'          => 'nullable|numeric|min:1',
            'notes'        => 'nullable|string',
            'match_date'   => 'nullable|date',
        ]);

        // ✅ Attach the currently logged-in user
        $validated['user_id'] = auth()->id();

        PlannedBet::create($validated);

        return redirect()->route('planned-bets.index')
            ->with('success', '✅ Planned bet added successfully!');
    }


    /**
     * Show the form for editing a planned bet.
     */
    

    public function edit($id)
    {
        // ✅ Fetch the planned bet with its related teams
        $plannedBet = PlannedBet::with(['homeTeam', 'awayTeam'])
            ->where('user_id', auth()->id()) // ensure user owns it
            ->findOrFail($id);

        // ✅ Fetch all teams for dropdowns
        $teams = Team::orderBy('name')->get();

        return view('backend.planned_bets.edit', compact('plannedBet', 'teams'));
    }


    /**
     * Update the specified planned bet.
     */
    public function update(Request $request, PlannedBet $plannedBet)
    {
        $validated = $request->validate([
            'home_team_id' => 'required|exists:teams,id',
            'away_team_id' => 'required|exists:teams,id|different:home_team_id',
            'prediction' => 'nullable|string|max:255',
            'odd' => 'nullable|numeric|min:1',
            'notes' => 'nullable|string',
            'match_date' => 'nullable|date',
            'status' => 'nullable|string|in:pending,decided,discarded,moved',
        ]);

        $plannedBet->update($validated);

        return redirect()->route('planned-bets.index')->with('success', 'Planned bet updated successfully!');
    }


    public function show($id)
    {
        try {
            // Load planned bet with related bets and team info
            $plannedBet = PlannedBet::with([
                'homeTeam',
                'awayTeam',
            ])->findOrFail($id);

            // Get banned teams list for quick checking in blade
            $bannedTeams = BannedTeam::pluck('team_id')->toArray();

            return view('backend.planned_bets.show', compact('plannedBet', 'bannedTeams'));

        } catch (\Exception $e) {
            \Log::error('Show Error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to load planned bet details.');
        }
    }


    /**
     * Remove the specified planned bet.
     */
    public function destroy(PlannedBet $plannedBet)
    {
        $plannedBet->delete();
        return redirect()->route('planned-bets.index')->with('success', 'Planned bet deleted successfully.');
    }
}
