<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\Bet;
use App\Models\BannedTeam;
use App\Models\Team;
use App\Models\WalletTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;

class TicketController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Base query with filters
        $ticketsQuery = Ticket::where('user_id',Auth::user()->id)
            ->when(request('search'), fn($q) => $q->where('id', request('search')))
            ->when(request('status'), fn($q) => $q->where('status', request('status')))
            ->when(request('from'), fn($q) => $q->whereDate('date', '>=', request('from')))
            ->when(request('to'), fn($q) => $q->whereDate('date', '<=', request('to')))
            ->when(request('min_stake'), fn($q) => $q->where('total_stake', '>=', request('min_stake')))
            ->when(request('max_stake'), fn($q) => $q->where('total_stake', '<=', request('max_stake')));

        // Paginated tickets
        $tickets = $ticketsQuery->clone()
            ->latest('date')
            ->withCount([
                'bets as won_bets_count' => fn($q) => $q->where('result','win'),
                'bets as lost_bets_count' => fn($q) => $q->where('result','lost')
            ])
            ->paginate(10);

        // Totals based on filtered query
        $totals = [
            'spent' => $ticketsQuery->clone()->sum('total_stake'),
            'return' => $ticketsQuery->clone()->where('status', 'win')
                            ->sum(DB::raw('COALESCE(total_return,0)')),
        ];

        $totalDeposits = WalletTransaction::where('user_id',Auth::user()->id)->where('type', 'deposit')->sum('amount');

        $balance= $totals['spent'] - $totalDeposits;
        $totals['net'] = $totals['return'] - $balance;

        // Ticket counts
        $totals['tickets'] = $ticketsQuery->clone()->count();
        $totals['won']     = $ticketsQuery->clone()->where('status', 'win')->count();
        $totals['lost']    = $ticketsQuery->clone()->where('status', 'lost')->count();

        // Win rate
        $totals['win_rate'] = $totals['tickets'] > 0
            ? round(($totals['won'] / $totals['tickets']) * 100, 2)
            : 0;


        // Chart data (profit/loss grouped by date)
        $chartData = $ticketsQuery->clone()
            ->select('date', DB::raw('SUM(COALESCE(total_return,0) - COALESCE(total_stake,0)) as net'))
            ->groupBy('date')
            ->orderBy('date') // safe because 'date' is in GROUP BY
            ->get();
 
        // Status distribution (won vs lost)
        $statusData = $ticketsQuery->clone()
            ->select('status', DB::raw('COUNT(*) as count'))
            ->groupBy('status')
            ->pluck('count','status');

        return view('backend.tickets.index', compact('tickets','totals','chartData','statusData','totalDeposits'));
    }

    /**
     * Show the form for creating a new resource.
     */ 
    public function create()
    {
      
         $teams = Team::with('country')->get();
        //$bannedTeams = BannedTeam::orderBy('team_name')->pluck('team_name')->toArray();
        return view('backend.tickets.create', compact('teams'));
    }
    /**
     * Store a newly created resource in storage.
     */
   
    public function store(Request $request)
    {
        $data = $request->validate([
            'ticket_number' => 'required|string|unique:tickets,ticket_number',
            'date' => 'required|date',
            'total_stake' => 'required|numeric|min:1',
            'total_odds' => 'required|numeric|min:1',
            'total_bonus' => 'nullable|numeric|min:0',
            'bets' => 'required|array|min:1',
            'bets.*.home_team_id' => 'required|exists:teams,id',
            'bets.*.away_team_id' => 'required|exists:teams,id|different:bets.*.home_team_id',
            'bets.*.bet_type' => 'required|string',
            'bets.*.odds' => 'required|numeric|min:1',            
        ]);

        // 🔹 Banned teams check
        $bannedTeams = \App\Models\BannedTeam::pluck('team_id')->toArray();

        $invalidTeams = collect($data['bets'])->filter(function ($bet) use ($bannedTeams) {
            return in_array($bet['home_team_id'], $bannedTeams) ||
                in_array($bet['away_team_id'], $bannedTeams);
        });

        if ($invalidTeams->isNotEmpty()) {
            return back()->withErrors([
                'bets' => "⚠ One or more selected teams are banned!"
            ])->withInput();
        }
       
        // Calculate potential return (stake * odds + bonus)
        $potentialReturn = ($data['total_stake'] * $data['total_odds']) + ($data['total_bonus'] ?? 0);


        DB::transaction(function () use ($data, $potentialReturn) {
            $wallet = \App\Models\Wallet::where('user_id',Auth::user()->id)->firstOrFail();

            // Check wallet balance before betting
            if ($wallet->balance + 1 < $data['total_stake']) {
                throw new \Exception("❌ Insufficient wallet balance to place this ticket.");
            }

            // Deduct stake from wallet
            $wallet->balance -= $data['total_stake'];
            $wallet->save();

            // Create ticket
            $ticket = \App\Models\Ticket::create([
                //'user_id' => auth()->id,
                'user_id' => Auth::user()->id,
                'ticket_number' => $data['ticket_number'],
                'date' => $data['date'],
                'total_stake' => $data['total_stake'],
                'total_odds' => $data['total_odds'],
                'total_return' => $potentialReturn,
                'status' => 'pending',
            ]);

            // Save bets
            foreach ($data['bets'] as $bet) {
                $ticket->bets()->create([
                    'home_team_id' => $bet['home_team_id'],
                    'away_team_id' => $bet['away_team_id'],
                    'bet_type' => $bet['bet_type'],
                    'odds' => $bet['odds'],
                    'result' => 'pending',
                ]);
            }

            // Record wallet transaction
            \App\Models\WalletTransaction::create([
                'user_id' => Auth::user()->id,
                'wallet_id' => $wallet->id,
                'type' => 'stake', // 🔹 use enum value from migration
                'amount' => $data['total_stake'],
                'reference' => $ticket->ticket_number,
                'description' => "Stake placed on ticket #{$ticket->ticket_number}"
            ]);
        });

        return redirect()->route('tickets.index')->with('success', '✅ Ticket created successfully!');
    }




    /**
     * Display the specified resource.
     */
    public function show(Ticket $ticket)
    {
        //         
         $ticket->load(['bets.homeTeam', 'bets.awayTeam']);

        return view('backend.tickets.show', compact('ticket'));
    }

    // Mark individual bet results, then auto-update ticket status + return
    public function updateResults(Request $request, Ticket $ticket)
    {
        $data = $request->validate([
            'bets' => 'required|array',
            'bets.*' => 'required|in:pending,win,lost',
        ]);

        DB::transaction(function () use ($data, $ticket) {
            // 1. Update bet results
            foreach ($data['bets'] as $betId => $result) {
                $ticket->bets()->where('id', $betId)->update(['result' => $result]);
            }

            // Reload bets after update
            $ticket->load('bets');

            // 2. Determine ticket status
            if ($ticket->bets->every(fn($b) => $b->result === 'win')) {
                $ticket->status = 'win';
            } elseif ($ticket->bets->contains(fn($b) => $b->result === 'lost')) {
                $ticket->status = 'lost';
            } else {
                $ticket->status = 'pending';
            }

            // 3. Calculate profit/loss
            if ($ticket->status === 'win') {
                $profit = $ticket->total_return - $ticket->total_stake;
            } elseif ($ticket->status === 'lost') {
                $profit = -$ticket->total_stake;
            } else {
                $profit = null; // still pending
            }

            $ticket->profit_loss = $profit;
            $ticket->save();

            // 4. Handle wallet update if ticket is won
            if ($ticket->status === 'win') {
                $wallet = \App\Models\Wallet::where('user_id',Auth::user()->id)->firstOrFail();
                $wallet->balance += $ticket->total_return;
                $wallet->save();

                // 5. Record wallet transaction
                \App\Models\WalletTransaction::create([
                    'user_id' => Auth::user()->id,
                    'wallet_id' => $wallet->id,
                    'type' => 'credit',
                    'amount' => $ticket->total_return, 
                    'reference' => $ticket->ticket_number,
                    'description' => "Winnings for ticket #{$ticket->ticket_number}"
                ]);
            }
        });

        return redirect()->route('tickets.show', $ticket)
                        ->with('success', '✅ Ticket results updated successfully!');
    }

    public function updateNotes(Request $request, Ticket $ticket)
    {
        $validated = $request->validate([
            'notes' => 'nullable|string|max:5000',
        ]);

        $ticket->update([
            'notes' => $validated['notes'],
        ]);

        return back()->with('success', 'Notes updated successfully.');
    }



    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Ticket $ticket)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Ticket $ticket)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Ticket $ticket)
    {
        //
    }

    
}
