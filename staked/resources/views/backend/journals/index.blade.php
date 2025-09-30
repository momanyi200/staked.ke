@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto p-6">
    <h1 class="text-3xl font-extrabold text-gray-900 mb-8 flex items-center">
        📓 My Journals
    </h1>
   <a href="{{ route('journals.calendar') }}"
           class="px-4 py-2 bg-indigo-600 text-white text-sm rounded-lg shadow hover:bg-indigo-700 transition">
            📅 View Calendar
        </a>

    <div class="space-y-6">
        @forelse($journals as $journal)
            <div class="p-6 bg-white rounded-2xl shadow hover:shadow-lg transition-shadow">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-xl font-semibold text-gray-800">
                        {{ $journal->date->format('F j, Y') }}
                    </h2>
                    <span class="text-sm text-gray-500">{{ $journal->created_at->diffForHumans() }}</span>
                </div>

                <div class="space-y-3">
                    <p class="text-gray-700 leading-relaxed">
                        <span class="font-semibold text-gray-900">Summary:</span>
                        {{ $journal->summary ?? '—' }}
                    </p>
                    <p class="text-gray-700 leading-relaxed">
                        <span class="font-semibold text-gray-900">Thoughts:</span>
                        {{ $journal->thoughts ?? '—' }}
                    </p>
                </div>

                <div class="mt-5 flex justify-end space-x-3">
                    <a href="{{ route('journals.edit', $journal) }}"
                       class="px-4 py-2 text-sm font-medium text-blue-600 bg-blue-50 rounded-lg hover:bg-blue-100">
                        ✏️ Edit
                    </a>
                    <form method="POST" action="{{ route('journals.destroy', $journal) }}">
                        @csrf @method('DELETE')
                        <button type="submit"
                                class="px-4 py-2 text-sm font-medium text-red-600 bg-red-50 rounded-lg hover:bg-red-100"
                                onclick="return confirm('Delete this journal?')">
                            🗑 Delete
                        </button>
                    </form>
                </div>
            </div>
        @empty
            <div class="p-6 bg-white border-2 border-dashed rounded-xl text-center text-gray-500">
                No journals yet. 
                <a href="{{ route('journals.create') }}" class="text-blue-600 hover:underline">Write your first one →</a>
            </div>
        @endforelse
    </div>

    <div class="mt-8">
        {{ $journals->links() }}
    </div>
</div>
@endsection
