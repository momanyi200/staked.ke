{{-- resources/views/dashboard/index.blade.php --}}
@extends('layouts.app')

@section('content')
@php 
  $user_id=Auth::user()->id;
@endphp
<div class="space-y-6">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        {{-- Wallet Balance --}}
        <div class="bg-gray-800 rounded-2xl shadow p-6">
            <h5 class="text-gray-400 text-sm">Wallet Balance</h5>
            <p class="text-3xl font-bold text-green-400 mt-2">
                Ksh {{ number_format($wallet->balance ?? 0, 2) }}
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
    
    
    {{-- Quick Stats --}}
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
      
        <div class="bg-gray-800 shadow rounded-lg p-4">
            <h3 class="text-gray-500">Total Deposits</h3>
            <p class="text-2xl font-bold text-green-600">{{ number_format($totalDeposits, 2) }}</p>
        </div>
        <div class="bg-gray-800 shadow rounded-lg p-4">
            <h3 class="text-gray-500">Total Stake</h3>
            <p class="text-2xl font-bold text-green-600">{{ number_format($totalStake, 2) }}</p>
        </div>
        <div class="bg-gray-800 shadow rounded-lg p-4">
            <h3 class="text-gray-500">Total Return</h3>
            <p class="text-2xl font-bold">{{ number_format($totalReturn, 2) }}</p>
        </div>
        <div class="bg-gray-800 shadow rounded-lg p-4">
            <h3 class="text-gray-500">Profit/Loss</h3>
            <p class="text-2xl font-bold {{ $profitLoss >= 0 ? 'text-green-600' : 'text-red-600' }}">
                {{ number_format($profitLoss, 2) }}
            </p>
        </div>
    </div>

    {{-- Performance Insights --}}
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mt-6">
        <div class="bg-gray-800 shadow rounded-lg p-4 text-center">
            <h2 class="text-sm text-gray-400">Average Odds</h2>
            <p class="text-2xl font-bold text-blue-400">{{ number_format($averageOdds, 2) }}</p>
        </div>

        <div class="bg-gray-800 shadow rounded-lg p-4 text-center">
            <h2 class="text-sm text-gray-400">Win Rate</h2>
            <p class="text-2xl font-bold text-green-400">{{ number_format($winRate, 2) }}%</p>
        </div>

        <div class="bg-gray-800 shadow rounded-lg p-4 text-center">
            <h2 class="text-sm text-gray-400">Break-even Win Rate</h2>
            <p class="text-2xl font-bold text-yellow-400">{{ number_format($breakEvenRate, 2) }}%</p>
        </div>

        <div class="bg-gray-800 shadow rounded-lg p-4 text-center">
            <h2 class="text-sm text-gray-400">ROI</h2>
            <p class="text-2xl font-bold {{ $roi >= 0 ? 'text-green-400' : 'text-red-400' }}">
                {{ number_format($roi, 2) }}%
            </p>
        </div>
    </div>

    {{-- Profit Gap --}}
    <div class="bg-gray-800 shadow rounded-lg p-4 mt-4 text-center">
        <h2 class="text-sm text-gray-400">Performance vs Break-even</h2>
        <p class="text-2xl font-bold {{ $profitGap >= 0 ? 'text-green-400' : 'text-red-400' }}">
            {{ $profitGap >= 0 ? '+' : '' }}{{ number_format($profitGap, 2) }}%
        </p>
        <p class="text-gray-500 text-sm mt-1">
            {{ $profitGap >= 0 ? 'Above break-even — profitable trend!' : 'Below break-even — needs adjustment.' }}
        </p>
    </div>

    <!-- Ticket Stats -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
        <div class="bg-gray-800 shadow rounded-lg p-4 text-center">
            <h2 class="text-sm text-gray-400">Total Tickets</h2>
            <p class="text-2xl font-bold text-gray-200">{{ $totalTickets }}</p>
        </div>
        <div class="bg-gray-800 shadow rounded-lg p-4 text-center">
            <h2 class="text-sm text-gray-400">Won Tickets</h2>
            <p class="text-2xl font-bold text-green-400">{{ $wonTickets }}</p>
        </div>
        <div class="bg-gray-800 shadow rounded-lg p-4 text-center">
            <h2 class="text-sm text-gray-400">Lost Tickets</h2>
            <p class="text-2xl font-bold text-red-400">{{ $lostTickets }}</p>
        </div>
    </div>

    {{-- Charts --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="bg-gray-800 shadow rounded-lg p-4">
            <h3 class="text-gray-700 font-semibold mb-2">Monthly Stakes vs Returns</h3>
            <canvas id="monthlyChart"></canvas>
        </div>
        <div class="bg-gray-800 shadow rounded-lg p-4">
            <h3 class="text-gray-700 font-semibold mb-2">Bet Outcomes</h3>
            <canvas id="outcomesChart"></canvas>
        </div>
    </div>

    {{-- Recent Tickets --}}
    <div class="bg-gray-800 shadow rounded-lg p-4">
        <h3 class="text-gray-700 font-semibold mb-2">Recent Tickets</h3>
        <table class="w-full text-sm text-left text-gray-600">
            <thead>
                <tr>
                    <th class="p-2">Ticket #</th>
                    <th class="p-2">Date</th>
                    <th class="p-2">Stake</th>
                    <th class="p-2">Return</th>
                    <th class="p-2">Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($recentTickets as $ticket)
                <tr class="border-t">
                    <td class="p-2">{{ $ticket->ticket_number }}</td>
                    <td class="p-2">{{ $ticket->date }}</td>
                    <td class="p-2">{{ $ticket->total_stake }}</td>
                    <td class="p-2">{{ $ticket->total_return }}</td>
                    <td class="p-2 capitalize">{{ $ticket->status }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    {{-- Recent Transactions --}}
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
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">

        {{-- Today’s Tickets --}}
        <div class="bg-white shadow rounded p-4">
            <h2 class="text-xl font-bold mb-3">🎫 Today’s Tickets</h2>
            @forelse($ticketsToday as $ticket)
                <div class="mb-3 border-b pb-2">
                    <p><strong>Ticket #:</strong> {{ $ticket->ticket_number }}</p>
                    <p><strong>Stake:</strong> {{ $ticket->total_stake }}</p>
                    <p><strong>Odds:</strong> {{ $ticket->total_odds }}</p>
                    <p><strong>Notes:</strong> {{ $ticket->notes ?? '—' }}</p>
                </div>
            @empty
                <p class="text-gray-500">No tickets placed today.</p>
            @endforelse
        </div>

        {{-- Today’s Journal --}}
        <div class="bg-white shadow rounded p-4">
            <h2 class="text-xl font-bold mb-3">📓 Today’s Journal</h2>
            @if($journalToday)
                <p><strong>Summary:</strong> {{ $journalToday->summary }}</p>
                <p class="mt-2"><strong>Thoughts:</strong> {{ $journalToday->thoughts }}</p>
            @else
                <p class="text-gray-500">No journal entry for today.</p>
                <a href="{{ route('journals.create') }}" class="inline-block mt-3 px-3 py-2 bg-blue-600 text-white rounded">
                    Write Today’s Journal
                </a>
            @endif
        </div>

    </div>

</div>

{{-- Chart.js --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Monthly Chart
    const monthlyCtx = document.getElementById('monthlyChart');
    new Chart(monthlyCtx, {
        type: 'line',
        data: {
            labels: @json($monthly->pluck('month')),
            datasets: [
                {
                    label: 'Stake',
                    data: @json($monthly->pluck('stake')),
                    borderColor: 'red',
                    fill: false,
                },
                {
                    label: 'Return',
                    data: @json($monthly->pluck('returns')),
                    borderColor: 'green',
                    fill: false,
                }
            ]
        }
    });

    // Outcomes Chart (Pie)
    const outcomesCtx = document.getElementById('outcomesChart');
    new Chart(outcomesCtx, {
        type: 'pie',
        data: {
            labels: ['Win', 'Lost', 'Pending'],
            datasets: [{
                data: [
                    {{ \App\Models\Ticket::where('user_id',$user_id)->where('status', 'win')->count() }},
                    {{ \App\Models\Ticket::where('user_id',$user_id)->where('status', 'lost')->count() }},
                    {{ \App\Models\Ticket::where('user_id',$user_id)->where('status', 'pending')->count() }},
                ],
                backgroundColor: ['green', 'red', 'orange']
            }]
        }
    });
</script>
@endsection
