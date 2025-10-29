<?php
namespace App\Http\Controllers;

use App\Models\Team;
use App\Models\Country;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class TeamController extends Controller
{
    // public function index()
    // { 
        
    //     $teams = Team::with('country')->orderBy('name')->paginate(10);
    //     return view('backend.teams.index', compact('teams'));
    // }

    public function index()
    {
        // Eager load countries, order by country then team name
        $teamsByCountry = Team::with('country')
            ->orderBy(Country::select('name')->whereColumn('countries.id', 'teams.country_id'))
            ->orderBy('name')
            ->get()
            ->groupBy(fn($team) => $team->country->name ?? 'No Country');

        return view('backend.teams.index', compact('teamsByCountry'));
    }
    

    public function create()
    {
        $countries=Country::all();
        return view('backend.teams.create',compact('countries'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => [
                'required',
                'string',
                Rule::unique('teams', 'name')->where(function ($query) use ($request) {
                    return $query->where('country_id', $request->country_id);
                }),
            ],
            'country_id' => 'required|exists:countries,id',
        ]);

        Team::create($request->only('name', 'country_id'));

        return redirect()->route('teams.index')->with('success', '✅ Team added successfully!');
    }

    public function edit(Team $team)
    {
        $countries=Country::all();
        return view('backend.teams.edit', compact('team','countries'));
    }

    public function update(Request $request, Team $team)
    {
        $request->validate([
            'name' => 'required|string|unique:teams,name,' . $team->id,
            'country' => 'nullable|string',
        ]);

        $team->update($request->only('name', 'country'));

        return redirect()->route('teams.index')->with('success', '✅ Team updated successfully!');
    }

    public function destroy(Team $team)
    {
        $team->delete();
        return redirect()->route('teams.index')->with('success', '🗑️ Team deleted successfully!');
    }

    public function review(Request $request)
    {
        $query = Team::query()
            ->withCount(['homeBets', 'awayBets'])
            ->with(['homeBets', 'awayBets']);

        if ($search = $request->input('search')) {
            $query->where('name', 'like', "%{$search}%");
        }

        $teams = $query->paginate(10);

        return view('backend.teams.review', compact('teams', 'search'));
    }

    public function show(Team $team)
    {
        $team->load('banned');

        $bets = $team->homeBets()
            ->with(['awayTeam', 'homeTeam'])
            ->union($team->awayBets()->with(['awayTeam', 'homeTeam']))
            ->get()
            ->sortByDesc('created_at');

        $groupedBets = $bets->groupBy(function ($bet) {
            return $bet->created_at->format('M d, Y');
        });

        $wins = $bets->where('result', 'won')->count();
        $losses = $bets->where('result', 'lost')->count();
        $pending = $bets->where('result', 'pending')->count();

        return view('backend.teams.show', compact('team', 'groupedBets', 'wins', 'losses', 'pending'));
    }

    

}
