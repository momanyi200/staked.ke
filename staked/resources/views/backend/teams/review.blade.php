@extends('layouts.app')

@section('content')
<div class="container mx-auto py-8">
    <h1 class="text-2xl font-bold mb-4 text-white">Teams You’ve Bet On</h1>

    <form method="GET" action="{{ route('review.teams') }}" class="mb-6 flex space-x-2">
        <input type="text" name="search" value="{{ $search ?? '' }}" 
               placeholder="Search team..." 
               class="border rounded p-2 w-full bg-gray-900 text-white">
        <button type="submit" class="bg-green-600 text-white px-4 rounded">Search</button>
    </form>

    <div class="bg-gray-800 rounded shadow p-4">
        @forelse ($teams as $team)
            <div class="border-b border-gray-700 py-3">
                <h2 class="text-lg font-semibold text-green-400">{{ $team->name }}</h2>
                <p>Home Bets: <strong>{{ $team->home_bets_count }}</strong></p>
                <p>Away Bets: <strong>{{ $team->away_bets_count }}</strong></p>

                <a href="{{ route('teams.show', $team) }}" 
                   class="text-blue-400 hover:underline">View Performance</a>
            </div>
        @empty
            <p class="text-gray-400">No teams found.</p>
        @endforelse
    </div>

    <div class="mt-6">
        {{ $teams->links() }}
    </div>
</div>
@endsection
