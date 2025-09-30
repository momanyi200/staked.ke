@extends('layouts.app')

@section('content')
    <h1 class="text-2xl font-semibold mb-4">Ticket #{{ $ticket->id }}</h1>

    <div class="bg-gray-800 rounded p-4 mb-6">
        <p><strong>Stake:</strong> {{ $ticket->total_stake }}</p>
        <p><strong>Total Odds:</strong> {{ $ticket->total_odds }}</p>
        <p><strong>Total Return:</strong> {{ $ticket->total_return }}</p>
        <p><strong>Profit/Loss:</strong> {{ $ticket->profit_loss ?? 'Pending' }}</p>
        <p><strong>Status:</strong> {{ ucfirst($ticket->status) }}</p>
    </div> 

    @if(!empty($ticket->notes))
        <div class="mt-6 bg-gray-800 p-4 rounded">
            <h3 class="text-lg font-semibold mb-2">Your Notes</h3>
            <p class="text-gray-300">{{ $ticket->notes }}</p>
        </div>
    @endif


    <h2 class="text-xl font-semibold mb-2">Bets</h2>
    <table class="min-w-full bg-gray-800 rounded-lg overflow-hidden">
        <thead>
            <tr class="bg-gray-700">
                <th class="px-4 py-2 text-start">Match</th>
                <th class="px-4 py-2 text-start">Bet Type</th>
                <th class="px-4 py-2 text-start">Odds</th>
                <th class="px-4 py-2 text-start">Result</th>
            </tr>
        </thead>
        <tbody>
            @foreach($ticket->bets as $bet)
                <tr class="border-b border-gray-700">
                    <td class="px-4 py-2">{{ $bet->homeTeam->name ?? 'N/A' }} v/s {{ $bet->awayTeam->name ?? 'N/A' }}</td>
                    <td class="px-4 py-2">{{ $bet->bet_type }}</td>
                    <td class="px-4 py-2">{{ $bet->odds }}</td>
                    <td class="px-4 py-2">{{ ucfirst($bet->result ?? 'Pending') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    @if($ticket->status=='pending')
        <form method="POST" action="{{ route('tickets.updateResults', $ticket) }}" class="mt-6 space-y-3">
            @csrf
            <h3 class="text-lg font-semibold">Update Results</h3>
            @foreach($ticket->bets as $bet)
                <div class="px-4">
                    <label class="mx-4">{{ $bet->homeTeam->name ?? 'N/A' }} v/s {{ $bet->awayTeam->name ?? 'N/A' }} - {{$bet->bet_type}}</label>
                    <select name="bets[{{ $bet->id }}]" class="bg-gray-800 border border-gray-600 rounded p-2">
                        <option value="pending" {{ $bet->result == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="win" {{ $bet->result == 'win' ? 'selected' : '' }}>Win</option>
                        <option value="lost" {{ $bet->result == 'lost' ? 'selected' : '' }}>Loss</option>
                    </select>
                </div>
            @endforeach

            <button type="submit" class="bg-green-500 px-4 py-2 rounded text-white">Update Ticket</button>
        </form>
    @endif

    {{-- Notes Form --}}
    @if($ticket->status <> 'pending' && empty($ticket->notes))
        <form method="POST" action="{{ route('tickets.updateNotes', $ticket) }}" class="mt-6 space-y-3">
             @csrf
            <div>
                <label class="block text-gray-700 font-medium mb-2">Notes / Reasoning (thoughts about the results)</label>
                <textarea name="notes" class="w-full border rounded p-2" rows="3"
                        placeholder="Why did you choose this bet?">{{ old('notes', $ticket->notes ?? '') }}</textarea>
            </div>
            <div>
                 <button type="submit" class="bg-green-500 px-4 py-2 rounded text-white">Update Ticket</button>
            </div>        
        </form>
    @endif    
@endsection