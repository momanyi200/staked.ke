<?php

// app/Http/Controllers/DashboardController.php
namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\Wallet;
use App\Models\WalletTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;
use App\Models\Journal;

class DashboardController extends Controller
{
    public function index()
    {
        $user_id=Auth::user()->id;
        $wallet = Wallet::where('user_id',$user_id)->first();
        // If wallet not yet created, create it
        if (!$wallet) {
            $wallet = \App\Models\Wallet::create([
                'user_id' => $user_id,
                'balance' => 0,
            ]);
        } 
        $transactions = WalletTransaction::where('user_id',$user_id)->latest()->take(5)->get();
        $totalDeposits = WalletTransaction::where('user_id',$user_id)->where('type', 'deposit')->sum('amount');
        $totalWithdrawals = WalletTransaction::where('user_id',$user_id)->where('type', 'withdrawal')->sum('amount');

        $wonTickets = Ticket::where('user_id',$user_id)->where('status', 'win')->count();
        $lostTickets = Ticket::where('user_id',$user_id)->where('status', 'lost')->count();

        $totalTickets = Ticket::where('user_id',$user_id)->count();
        $totalStake = Ticket::where('user_id',$user_id)->sum('total_stake');
        $totalReturn = Ticket::where('user_id',$user_id)->where('status','win')->sum('total_return');

        //profit== totalStake - deposits - totalReturn
        $balance=$totalStake - $totalDeposits;
        $profitLoss = $totalReturn - $balance;

        // Monthly stakes & returns
        $monthly = Ticket::select(
                        DB::raw("DATE_FORMAT(date, '%Y-%m') as month"),
                        DB::raw("SUM(total_stake) as stake"),
                        DB::raw("SUM(total_return) as returns")
                    )->where('user_id',$user_id)
                    ->groupBy('month')
                    ->orderBy('month')
                    ->get();

        $recentTickets = Ticket::where('user_id',$user_id)->latest()->take(5)->get();
        $today = now()->toDateString();
        $ticketsToday = Ticket::whereDate('date', $today)
                            ->where('user_id', Auth::id())
                            ->get();

        $journalToday = Journal::whereDate('date', $today)
                            ->where('user_id', Auth::id())
                            ->first();

        return view('backend.dashboard.index', compact(
            'totalTickets', 'totalStake', 'totalReturn', 'profitLoss',
            'monthly', 'recentTickets','wallet','wonTickets','lostTickets','transactions','totalDeposits','today','ticketsToday','journalToday'
        ));
    }
}

