@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto bg-gray-800 p-6 rounded-lg shadow-lg mt-6 text-gray-200">

    <h2 class="text-2xl font-semibold mb-4 text-green-400">
        Edit Planned Bet
    </h2>

    <form action="{{ route('planned-bets.update', $plannedBet->id) }}" method="POST" class="space-y-5">
        @csrf
        @method('PUT')

         @include('backend.planned_bets._form')


        <div>
            <label class="block text-sm font-medium mb-1">Prediction</label>
            <input type="text" name="prediction" value="{{ old('prediction', $plannedBet->prediction) }}"
                   class="w-full bg-gray-700 rounded p-2">
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">Odd</label>
            <input type="number" step="0.01" name="odd" value="{{ old('odd', $plannedBet->odd) }}"
                   class="w-full bg-gray-700 rounded p-2">
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">Match Date</label>
            <input type="datetime-local" name="match_date"
                   value="{{ old('match_date', $plannedBet->match_date ? \Carbon\Carbon::parse($plannedBet->match_date)->format('Y-m-d\TH:i') : '') }}"
                   class="w-full bg-gray-700 rounded p-2">
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">Notes</label>
            <textarea name="notes" class="w-full bg-gray-700 rounded p-2">{{ old('notes', $plannedBet->notes) }}</textarea>
        </div>

        <div class="flex justify-between">
            <a href="{{ route('planned-bets.index') }}" class="px-4 py-2 bg-gray-600 rounded hover:bg-gray-500">Cancel</a>
            <button type="submit" class="px-4 py-2 bg-green-600 rounded hover:bg-green-700">Update</button>
        </div>
    </form>
</div>
@endsection
