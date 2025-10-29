@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto bg-gray-800 p-6 rounded-lg shadow-lg mt-6 text-gray-200">

    <h2 class="text-2xl font-semibold mb-4 text-green-400">
        Planned Bet Details
    </h2>

    @if(isset($plannedBet))
        <div class="space-y-3">
            <p><strong>Match:</strong>
                {{ optional($plannedBet->homeTeam)->name ?? 'Unknown' }}
                vs
                {{ optional($plannedBet->awayTeam)->name ?? 'Unknown' }}
            </p>

            <p><strong>Prediction:</strong> {{ $plannedBet->prediction ?? 'N/A' }}</p>
            <p><strong>Odd:</strong> {{ $plannedBet->odd ?? 'N/A' }}</p>
            <p><strong>Notes:</strong> {{ $plannedBet->notes ?? 'None' }}</p>

            <p><strong>Match Date:</strong>
                {{ $plannedBet->match_date ? \Carbon\Carbon::parse($plannedBet->match_date)->format('d M Y, H:i') : 'Not set' }}
            </p>

            <p><strong>Created At:</strong>
                {{ $plannedBet->created_at->format('d M Y, H:i') }}
            </p>
        </div>
    @else
        <p class="text-gray-400">No planned bet found.</p>
    @endif

    <div class="mt-6 flex justify-between">
        <a href="{{ route('planned-bets.index') }}"
           class="px-4 py-2 bg-gray-700 rounded hover:bg-gray-600">← Back to List</a>

        <a href="{{ route('planned-bets.edit', $plannedBet->id) }}"
           class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Edit</a>
    </div>
</div>
@endsection
