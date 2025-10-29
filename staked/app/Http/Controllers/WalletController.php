<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\WalletService;
use App\Models\WalletTransaction;
use Exception;
use Auth;

class WalletController extends Controller
{
    protected $walletService;

    public function __construct(WalletService $walletService)
    {
        $this->walletService = $walletService;
    }

    public function index(Request $request){

        $user_id=Auth::user()->id;
        $query = WalletTransaction::where('user_id',$user_id);

        // Filter by type
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        // Filter by date range
        if ($request->filled('from')) {
            $query->whereDate('created_at', '>=', $request->from);
        }
        if ($request->filled('to')) {
            $query->whereDate('created_at', '<=', $request->to);
        }

        $transactions = $query->latest()->paginate(10);
        $balance=$this->walletService->getBalance();        

         // Totals
        $totalDeposits = WalletTransaction::where('user_id',$user_id)->where('type', 'deposit')->sum('amount');
        $totalWithdrawals = WalletTransaction::where('user_id',$user_id)->where('type', 'withdrawal')->sum('amount');

        return view('backend.wallet.index',compact('transactions','balance','totalDeposits','totalWithdrawals'));

    }

    public function deposit(Request $request)
    {
        $data = $request->validate([
            'amount' => 'required|numeric|min:1',
        ]);

        $this->walletService->deposit($data['amount'], null, "Manual deposit");

        return back()->with('success', "Deposited Ksh {$data['amount']} successfully!");
    }

    public function withdraw(Request $request)
    {
        $data = $request->validate([
            'amount' => 'required|numeric|min:1',
        ]);

        try {
            $this->walletService->withdraw($data['amount'], null, "Manual withdrawal");
            return back()->with('success', "Withdrew Ksh {$data['amount']} successfully!");
        } catch (Exception $e) {
            return back()->withErrors(['amount' => $e->getMessage()]);
        }
    }
}
