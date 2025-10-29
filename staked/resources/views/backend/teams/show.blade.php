@extends('layouts.app')

@section('content')
<div class="container mx-auto py-8 text-white">
  
    <h1 class="text-2xl font-bold mb-4">
        {{ $team->name }}
        @if($team->banned)
            <span class="ml-2 text-red-500 text-sm font-semibold bg-red-900 px-2 py-1 rounded">BANNED</span>
        @endif
        - Performance
    </h1>

    @if($team->banned)
        <div class="bg-red-800 text-white p-3 rounded mb-4">
            ⚠️ <strong>This team is banned.</strong>
            @if($team->banned->reason)
                <p class="mt-2 text-sm text-gray-200">Reason: {{ $team->banned->reason }}</p>
            @endif
            <p class="mt-2 text-xs text-gray-400">Banned on: {{ $team->banned->created_at->format('M d, Y') }}</p>
        </div>
    @endif

    <div class="grid grid-cols-3 gap-4 mb-6">
        <div class="bg-green-800 p-4 rounded text-center">
            <h2 class="text-lg font-semibold">Wins</h2>
            <p class="text-2xl font-bold">{{ $wins }}</p>
        </div>
        <div class="bg-red-800 p-4 rounded text-center">
            <h2 class="text-lg font-semibold">Losses</h2>
            <p class="text-2xl font-bold">{{ $losses }}</p>
        </div>
        <div class="bg-yellow-600 p-4 rounded text-center">
            <h2 class="text-lg font-semibold">Pending</h2>
            <p class="text-2xl font-bold">{{ $pending }}</p>
        </div>
    </div>

    <div class="bg-gray-800 p-4 rounded">
        <h2 class="text-xl font-semibold mb-3">Bets Grouped by Date</h2>

        @forelse($groupedBets as $date => $bets)
            <div class="mb-6">
                <h3 class="text-lg font-semibold text-green-400 mb-2 border-b border-gray-700 pb-1">
                    {{ $date }}
                </h3>

                <table class="w-full border border-gray-700 text-sm mb-2">
                    <thead class="bg-gray-700">
                        <tr>
                            <th class="p-2 text-left">Match</th>
                            <th class="p-2 text-left">Bet Type</th>
                            <th class="p-2 text-left">Odds</th>
                            <th class="p-2 text-left">Result</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($bets as $bet)
                            <tr class="border-t border-gray-700">
                                <td class="p-2">{{ $bet->homeTeam->name }} vs {{ $bet->awayTeam->name }}</td>
                                <td class="p-2">{{ $bet->bet_type }}</td>
                                <td class="p-2">{{ $bet->odds }}</td>
                                <td class="p-2">
                                    @if($bet->result == 'won')
                                        <span class="text-green-400">Won</span>
                                    @elseif($bet->result == 'lost')
                                        <span class="text-red-400">Lost</span>
                                    @else
                                        <span class="text-yellow-400">Pending</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @empty
            <p class="text-gray-400">No bets found for this team.</p>
        @endforelse
    </div>
</div>
@endsection
