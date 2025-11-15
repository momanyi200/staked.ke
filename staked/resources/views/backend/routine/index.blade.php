@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto mt-8">
    <h1 class="text-2xl font-bold mb-6">Bet Guidelines</h1>
    <a href="{{ route('bet-guidelines.create') }}" class=" mb-4 bg-green-600 hover:bg-green-700 px-4 py-2 rounded">+ Add New</a>
    <hr class="my-5"/>
    <table class="w-full text-left bg-gray-800 text-white rounded-lg overflow-hidden">
        <thead>
            <tr class="bg-gray-700">
                <th class="px-4 py-2">#</th>
                <th class="px-4 py-2">Type</th>
                <th class="px-4 py-2">Title</th>
                <th class="px-4 py-2">Description</th>
                <th class="px-4 py-2">Active</th>
                <th class="px-4 py-2">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($guidelines as $g)
            <tr class="border-b border-gray-700">
                <td class="px-4 py-2">{{ $g->id }}</td>
                <td class="px-4 py-2">{{ ucfirst($g->type) }}</td>
                <td class="px-4 py-2">{{ $g->title }}</td>
                <td class="px-4 py-2">{{ $g->description }}</td>
                <td class="px-4 py-2">{{ $g->is_active ? 'Yes' : 'No' }}</td>
                <td class="px-4 py-2 space-x-2">
                    <a href="{{ route('bet-guidelines.edit', $g->id) }}" class="text-blue-400">Edit</a>
                    <form action="{{ route('bet-guidelines.destroy', $g->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Delete this guideline?');">
                        @csrf
                        @method('DELETE')
                        <button class="text-red-500">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
