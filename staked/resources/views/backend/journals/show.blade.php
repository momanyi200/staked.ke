@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto p-6">
    <div class="bg-white shadow-md rounded-lg p-6">
        <h1 class="text-2xl font-bold mb-4">
            Journal - {{ \Carbon\Carbon::parse($journal->date)->format('F j, Y') }}
        </h1>

        <p class="mb-4"><strong>Summary:</strong> {{ $journal->summary ?? 'No summary provided' }}</p>
        <p class="mb-6"><strong>Thoughts:</strong> {{ $journal->thoughts ?? 'No thoughts recorded' }}</p>

        <div class="flex space-x-3">
            <a href="{{ route('journals.edit', $journal) }}"
               class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                Edit
            </a>

            <a href="{{ route('journals.index') }}"
               class="px-4 py-2 bg-gray-600 text-white rounded hover:bg-gray-700">
                Back
            </a>
        </div>
    </div>
</div>
@endsection
