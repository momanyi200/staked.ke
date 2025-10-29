@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto bg-gray-800 p-6 rounded-lg shadow-lg">
    <h1 class="text-2xl font-semibold text-white mb-6">Add Planned Bet</h1>

    <form action="{{ route('planned-bets.store') }}" method="POST" class="space-y-4">
        @csrf

          @include('backend.planned_bets._form')

        <div>
            <label class="block text-gray-300 mb-1">Prediction</label>
            <input type="text" name="prediction" value="{{ old('prediction') }}" placeholder="e.g. Over 2.5, Home Win"
                class="w-full bg-gray-900 border border-gray-700 text-gray-200 rounded p-2">
        </div>

        <div>
            <label class="block text-gray-300 mb-1">Odds</label>
            <input type="number" name="odd" step="0.01" value="{{ old('odd') }}"
                class="w-full bg-gray-900 border border-gray-700 text-gray-200 rounded p-2">
        </div>

        <div>
            <label class="block text-gray-300 mb-1">Match Date</label>
            <input type="datetime-local" name="match_date" value="{{ old('match_date') }}"
                class="w-full bg-gray-900 border border-gray-700 text-gray-200 rounded p-2">
        </div>

        <div>
            <label class="block text-gray-300 mb-1">Notes</label>
            <textarea name="notes" rows="3"
                class="w-full bg-gray-900 border border-gray-700 text-gray-200 rounded p-2">{{ old('notes') }}</textarea>
        </div>

        <div class="flex justify-end space-x-2">
            <a href="{{ route('planned-bets.index') }}" class="px-4 py-2 bg-gray-700 rounded text-gray-200 hover:bg-gray-600">Cancel</a>
            <button type="submit" class="px-4 py-2 bg-green-600 rounded text-white hover:bg-green-500">Save</button>
        </div>
    </form>
</div>
@endsection
