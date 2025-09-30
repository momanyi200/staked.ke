@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto p-6 bg-white shadow rounded">
    <h1 class="text-2xl font-bold mb-4">New Journal Entry</h1>

    <form method="POST" action="{{ route('journals.store') }}" class="space-y-4">
        @csrf

        <div>
            <label class="block text-gray-700">Date</label>
            <input type="date" name="date" class="w-full border rounded p-2" value="{{ old('date', now()->toDateString()) }}">
        </div>

        <div>
            <label class="block text-gray-700">Summary of the Day</label>
            <textarea name="summary" class="w-full border rounded p-2" rows="4">{{ old('summary') }}</textarea>
        </div>

        <div>
            <label class="block text-gray-700">Thoughts & Reflections</label>
            <textarea name="thoughts" class="w-full border rounded p-2" rows="4">{{ old('thoughts') }}</textarea>
        </div>

        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">Save Journal</button>
    </form>
</div>
@endsection
