{{-- resources/views/dashboard/index.blade.php --}}
@extends('layouts.app')

@section('content')    

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        {{-- Wallet Balance --}}
        <div class="bg-gray-800 rounded-2xl shadow p-6">
            <h5 class="text-gray-400 text-sm">Wallet Balance</h5>
            <p class="text-3xl font-bold text-green-400 mt-2">
                Ksh {{ number_format($balance, 2) }}
            </p>
        </div>

        {{-- Deposit --}}
        <div class="bg-gray-800 rounded-2xl shadow p-6">
            <h5 class="text-gray-400 text-sm mb-2">Deposit</h5>
            <form method="POST" action="{{ route('wallet.deposit') }}" class="flex gap-2">
                @csrf
                <input type="number" step="0.01" name="amount" placeholder="Amount"
                       class="flex-1 rounded-lg bg-gray-900 border border-gray-700 text-gray-200 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500"
                       required>
                <button class="bg-green-600 hover:bg-green-700 text-white font-semibold px-4 py-2 rounded-lg">
                    Deposit
                </button>
            </form>
        </div>

        {{-- Withdraw --}}
        <div class="bg-gray-800 rounded-2xl shadow p-6">
            <h5 class="text-gray-400 text-sm mb-2">Withdraw</h5>
            <form method="POST" action="{{ route('wallet.withdraw') }}" class="flex gap-2">
                @csrf
                <input type="number" step="0.01" name="amount" placeholder="Amount"
                       class="flex-1 rounded-lg bg-gray-900 border border-gray-700 text-gray-200 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-red-500"
                       required>
                <button class="bg-red-600 hover:bg-red-700 text-white font-semibold px-4 py-2 rounded-lg">
                    Withdraw
                </button>
            </form>
            @error('amount')
                <p class="text-red-400 text-sm mt-2">{{ $message }}</p>
            @enderror
        </div>
    </div>
    <div class="px-6 py-4 border-b border-gray-700 flex items-center justify-between">
        <h5 class="text-gray-200 font-semibold">Recent Transactions</h5>
        <form method="GET" action="{{ route('wallet.index') }}" class="flex gap-3">
            {{-- Type Filter --}}
            <select name="type" class="bg-gray-900 border border-gray-700 text-gray-200 rounded-lg px-3 py-2">
                <option value="">All Types</option>
                <option value="deposit" {{ request('type')=='deposit' ? 'selected' : '' }}>Deposit</option>
                <option value="withdrawal" {{ request('type')=='withdrawal' ? 'selected' : '' }}>Withdrawal</option>
                <option value="stake" {{ request('type')=='stake' ? 'selected' : '' }}>Stake</option>
                <option value="return" {{ request('type')=='return' ? 'selected' : '' }}>Return</option>
            </select>

            {{-- Date Range --}}
            <input type="date" name="from" value="{{ request('from') }}"
                class="bg-gray-900 border border-gray-700 text-gray-200 rounded-lg px-3 py-2">
            <input type="date" name="to" value="{{ request('to') }}"
                class="bg-gray-900 border border-gray-700 text-gray-200 rounded-lg px-3 py-2">

            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg">
                Filter
            </button>
        </form>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
        {{-- Total Deposits --}}
        <div class="bg-gray-800 rounded-2xl shadow p-6">
            <h5 class="text-gray-400 text-sm">Total Deposits</h5>
            <p class="text-2xl font-bold text-green-400 mt-2">
                Ksh {{ number_format($totalDeposits, 2) }}
            </p>
        </div>

        {{-- Total Withdrawals --}}
        <div class="bg-gray-800 rounded-2xl shadow p-6">
            <h5 class="text-gray-400 text-sm">Total Withdrawals</h5>
            <p class="text-2xl font-bold text-red-400 mt-2">
                Ksh {{ number_format($totalWithdrawals, 2) }}
            </p>
        </div>

    </div>
    <div class="mt-8 bg-gray-800 rounded-2xl shadow overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-700">
            <h5 class="text-gray-200 font-semibold">Recent Transactions</h5>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-700">
                <thead class="bg-gray-900">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase">#</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase">Type</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase">Amount</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase">Reference</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase">Description</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase">Date</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-700 bg-gray-800">
                    @forelse($transactions as $tx)
                        <tr>
                            <td class="px-6 py-4 text-gray-300">{{ $tx->id }}</td>
                            <td class="px-6 py-4">
                                @if($tx->type == 'deposit')
                                    <span class="px-2 py-1 text-xs rounded-full bg-green-600 text-white">Deposit</span>
                                @elseif($tx->type == 'withdrawal')
                                    <span class="px-2 py-1 text-xs rounded-full bg-red-600 text-white">Withdraw</span>
                                @elseif($tx->type == 'stake')
                                    <span class="px-2 py-1 text-xs rounded-full bg-yellow-500 text-black">Stake</span>
                                @elseif($tx->type == 'return')
                                    <span class="px-2 py-1 text-xs rounded-full bg-blue-500 text-white">Return</span>
                                @else
                                    <span class="px-2 py-1 text-xs rounded-full bg-gray-500 text-white">{{ ucfirst($tx->type) }}</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-gray-200">Ksh {{ number_format($tx->amount, 2) }}</td>
                            <td class="px-6 py-4 text-gray-400">{{ $tx->reference ?? '-' }}</td>
                            <td class="px-6 py-4 text-gray-400">{{ $tx->description ?? '-' }}</td>
                            <td class="px-6 py-4 text-gray-400">{{ $tx->created_at->format('d M Y H:i') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-4 text-center text-gray-500">No transactions yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
             {{-- Pagination --}}
            <div class="mt-6">
                {{ $transactions->links() }}
            </div>
        </div>
    </div>
@endsection    