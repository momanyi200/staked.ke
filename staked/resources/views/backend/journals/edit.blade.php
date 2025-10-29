@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto p-6">
    <div class="bg-white shadow-md rounded-lg p-6">
        <h1 class="text-2xl font-bold mb-6">Edit Journal</h1>

        <form method="POST" action="{{ route('journals.update', $journal) }}" class="space-y-6">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-gray-700 font-medium mb-2">Date</label>
                <input type="date" name="date" value="{{ old('date', $journal->date) }}"
                       class="w-full border-gray-300 rounded-md">
                @error('date')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-gray-700 font-medium mb-2">Summary</label>
                <textarea name="summary" rows="3"
                          class="w-full border-gray-300 rounded-md">{{ old('summary', $journal->summary) }}</textarea>
                @error('summary')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-gray-700 font-medium mb-2">Thoughts</label>
                <textarea name="thoughts" rows="5"
                          class="w-full border-gray-300 rounded-md">{{ old('thoughts', $journal->thoughts) }}</textarea>
                @error('thoughts')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex space-x-3">
                <button type="submit"
                        class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                    Update
                </button>
                <a href="{{ route('journals.show', $journal) }}"
                   class="px-4 py-2 bg-gray-600 text-white rounded hover:bg-gray-700">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
