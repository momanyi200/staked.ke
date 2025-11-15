@extends('layouts.app')

@section('content')
    <h1 class="text-2xl font-semibold mb-6">Tickets</h1>

    {{-- Create new ticket button --}}
    <a href="{{ route('tickets.create') }}" 
       class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">
        + New Ticket
    </a> 

    {{-- Summary Cards --}}
    <div class="grid grid-cols-1 sm:grid-cols-4 gap-6 mt-6">
        {{-- Total Spent --}}
        <div class="bg-gray-800 p-6 rounded-lg shadow-md text-center">
            <h3 class="text-lg font-semibold text-gray-300 mb-2">Total Deposit</h3>
            <p class="text-2xl font-bold text-red-400">
                {{ number_format($totalDeposits, 2) }}
            </p>
        </div>
        {{-- Total Spent --}}
        <div class="bg-gray-800 p-6 rounded-lg shadow-md text-center">
            <h3 class="text-lg font-semibold text-gray-300 mb-2">Total Staked</h3>
            <p class="text-2xl font-bold text-red-400">
                {{ number_format($totals['spent'], 2) }}
            </p>
        </div>

        {{-- Total Return --}}
        <div class="bg-gray-800 p-6 rounded-lg shadow-md text-center">
            <h3 class="text-lg font-semibold text-gray-300 mb-2">Total Return</h3>
            <p class="text-2xl font-bold text-green-400">
                {{ number_format($totals['return'], 2) }}
            </p>
        </div>

        {{-- Net --}}
        <div class="bg-gray-800 p-6 rounded-lg shadow-md text-center">
            <h3 class="text-lg font-semibold text-gray-300 mb-2">Available balance</h3>
            <p class="text-2xl font-bold {{ $totals['net'] >= 0 ? 'text-green-400' : 'text-red-400' }}">
                  Ksh {{ number_format($wallet->balance ?? 0, 2) }}
            </p>
        </div>
    </div>

    {{-- Filters --}}
    <form method="GET" class="flex flex-wrap items-end gap-3 mt-6 bg-gray-800 p-4 rounded-lg shadow">
        
        {{-- Ticket ID Search --}}
        <div>
            <label for="search" class="block text-gray-400 text-sm mb-1">Ticket ID</label>
            <input type="text" name="search" id="search" value="{{ request('search') }}"
                placeholder="e.g. 101"
                class="px-3 py-2 rounded bg-gray-700 text-white w-40">
        </div>

        {{-- Status Filter --}}
        <div>
            <label for="status" class="block text-gray-400 text-sm mb-1">Status</label>
            <select name="status" id="status" class="px-3 py-2 rounded bg-gray-700 text-white w-32">
                <option value="">All</option>
                <option value="win" {{ request('status')=='win' ? 'selected' : '' }}>Win</option>
                <option value="lost" {{ request('status')=='lost' ? 'selected' : '' }}>Lost</option>
            </select>
        </div>

        {{-- Date Range --}}
        <div>
            <label for="from" class="block text-gray-400 text-sm mb-1">From</label>
            <input type="date" name="from" id="from" value="{{ request('from') }}"
                class="px-3 py-2 rounded bg-gray-700 text-white">
        </div>
        <div>
            <label for="to" class="block text-gray-400 text-sm mb-1">To</label>
            <input type="date" name="to" id="to" value="{{ request('to') }}"
                class="px-3 py-2 rounded bg-gray-700 text-white">
        </div>

        {{-- Min/Max Stake --}}
        <div>
            <label for="min_stake" class="block text-gray-400 text-sm mb-1">Min Stake</label>
            <input type="number" step="0.01" name="min_stake" id="min_stake" value="{{ request('min_stake') }}"
                class="px-3 py-2 rounded bg-gray-700 text-white w-32">
        </div>
        <div>
            <label for="max_stake" class="block text-gray-400 text-sm mb-1">Max Stake</label>
            <input type="number" step="0.01" name="max_stake" id="max_stake" value="{{ request('max_stake') }}"
                class="px-3 py-2 rounded bg-gray-700 text-white w-32">
        </div>

        {{-- Submit + Reset --}}
        <div class="flex gap-4">
            <button type="submit" 
                    class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                Filter
            </button>

            <a href="{{ route('tickets.index') }}" 
            class="bg-gray-600 text-white px-4 py-2 rounded hover:bg-gray-700">
                Reset
            </a>
        </div>

    </form>

    {{-- Move Export Buttons OUTSIDE the form --}}
    <div class="flex gap-4 mt-4">
       <a id="exportPdf"
        class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">
            Export PDF
        </a>

        <a id="exportExcel"
        class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
            Export Excel
        </a>

    </div>

    

    {{-- Summary Section --}}
    <div class="mt-6 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        {{-- Win Rate --}}
        <div class="bg-gray-800 p-5 rounded-lg shadow">
            <p class="text-sm text-gray-400">Win Rate</p>
            <p class="text-2xl font-bold text-blue-400">
                {{ $totals['win_rate'] ?? 0 }}%
            </p>
        </div>

        {{-- Total Tickets --}}
        <div class="bg-gray-800 p-5 rounded-lg shadow">
            <p class="text-sm text-gray-400">Total Tickets</p>
            <p class="text-2xl font-bold text-white">{{ $totals['tickets'] ?? 0 }}</p>
        </div>

        {{-- Won Tickets --}}
        <div class="bg-gray-800 p-5 rounded-lg shadow">
            <p class="text-sm text-gray-400">Won Tickets</p>
            <p class="text-2xl font-bold text-green-400">{{ $totals['won'] ?? 0 }}</p>
        </div>

        {{-- Lost Tickets --}}
        <div class="bg-gray-800 p-5 rounded-lg shadow">
            <p class="text-sm text-gray-400">Lost Tickets</p>
            <p class="text-2xl font-bold text-red-400">{{ $totals['lost'] ?? 0 }}</p>
        </div>
    </div>

    {{-- SEARCH SUMMARY --}}
    <div class="mt-6 grid grid-cols-1 sm:grid-cols-4 gap-6">
        
        {{-- Total Deposits --}}
        <div class="bg-gray-800 p-5 rounded-lg shadow text-center">
            <p class="text-sm text-gray-400">Total Deposits (Filtered)</p>
            <p class="text-2xl font-bold text-blue-400">
                Ksh {{ number_format($totalDeposits, 2) }}
            </p>
        </div>

        {{-- Total Stake --}}
        <div class="bg-gray-800 p-5 rounded-lg shadow text-center">
            <p class="text-sm text-gray-400">Total Stake (Filtered)</p>
            <p class="text-2xl font-bold text-red-400">
                Ksh {{ number_format($totals['spent'], 2) }}
            </p>
        </div>

        {{-- Total Win --}}
        <div class="bg-gray-800 p-5 rounded-lg shadow text-center">
            <p class="text-sm text-gray-400">Total Wins (Filtered)</p>
            <p class="text-2xl font-bold text-green-400">
                Ksh {{ number_format($totals['return'], 2) }}
            </p>
        </div>

        {{-- Total Profit --}}
        <div class="bg-gray-800 p-5 rounded-lg shadow text-center">
            <p class="text-sm text-gray-400">Profit / Loss</p>
            <p class="text-2xl font-bold {{ $totals['profit'] >= 0 ? 'text-green-400' : 'text-red-400' }}">
                Ksh {{ number_format($totals['profit'], 2) }}
            </p>
        </div>

    </div>



    {{-- Tickets Section --}}
    <div class="mt-8 space-y-6">
        @forelse($tickets as $ticket)
            <div class="bg-gray-900 rounded-2xl p-5 shadow-md hover:shadow-lg transition w-full border border-gray-700">
                {{-- Header --}}
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-lg font-bold text-white">🎟 Ticket #{{ $ticket->id }}</h2>
                    <span class="px-3 py-0.5 rounded-full text-xs font-semibold tracking-wide
                        {{ $ticket->status === 'won' ? 'bg-green-500/20 text-green-400' : 'bg-red-500/20 text-red-400' }}">
                        {{ ucfirst($ticket->status) }}
                    </span>
                </div>

                {{-- Ticket Stats --}}
                <div class="grid grid-cols-4 gap-4 items-center text-center text-sm">
                    <div>
                        <p class="text-gray-400 text-xs">Stake</p>
                        <p class="font-semibold text-white">{{ $ticket->total_stake }}</p>
                    </div>
                    <div>
                        <p class="text-gray-400 text-xs">Total Odds</p>
                        <p class="font-semibold text-yellow-400">{{ $ticket->total_odds }}</p>
                    </div>
                    <div>
                        <p class="text-gray-400 text-xs">Return</p>
                        <p class="font-semibold {{ $ticket->status === 'won' ? 'text-green-400' : 'text-gray-500' }}">
                            {{ $ticket->status <> 'loss' ? $ticket->total_return : 0 }}
                        </p>
                    </div>
                    <div>
                        <a href="{{ route('tickets.show', $ticket) }}" 
                            class="inline-block px-3 py-1.5 rounded-md bg-blue-600 text-white text-xs font-medium hover:bg-blue-500 transition">
                            View
                        </a>
                        @if($ticket->status=='pending')
                            <form action="{{ route('tickets.destroy', $ticket) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this ticket?');" class="mt-3">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-600 text-white px-3 py-1 rounded">Delete</button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>

        @empty
            <div class="text-center text-gray-400">
                No tickets yet.
            </div>
        @endforelse
    </div>



    {{-- Pagination --}}
    <div class="mt-6">
        {{ $tickets->links() }}
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const updateLinks = () => {
                const params = new URLSearchParams();

                ['search', 'status', 'from', 'to', 'min_stake', 'max_stake'].forEach(field => {
                    const value = document.getElementById(field)?.value;
                    if (value) params.append(field, value);
                });

                document.getElementById('exportPdf').href =
                    "{{ route('tickets.export.pdf') }}?" + params.toString();

                document.getElementById('exportExcel').href =
                    "{{ route('tickets.export.excel') }}?" + params.toString();
            };

            // Update links on any filter input change
            document.querySelectorAll('input, select').forEach(el => {
                el.addEventListener('change', updateLinks);
            });

            updateLinks();
        });
    </script>



@endsection
