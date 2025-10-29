@extends('layouts.app')

@section('content')
<div class="flex justify-between items-center mb-4">
    <h1 class="text-2xl font-bold text-gray-200">Banned Teams</h1>
    <a href="{{ route('banned-teams.create') }}" 
       class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg">
       + Add Team
    </a>
</div>

@if(session('success'))
    <div class="bg-green-500 text-white p-2 rounded mb-4">
        {{ session('success') }}
    </div>
@endif

<div class="bg-zinc-800 rounded-lg shadow p-4">
    <table class="w-full text-left text-gray-300">
        <thead class="border-b border-zinc-700">
            <tr>
                <th class="py-2 px-3">#</th>
                <th class="py-2 px-3">Team Name</th>
                <th class="py-2 px-3">Reason</th>
                <th class="py-2 px-3">Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse($teams as $team)
            <tr class="border-b border-zinc-700">
                <td class="py-2 px-3">{{ $loop->iteration }}</td>
                <td class="py-2 px-3 font-semibold">{{ $team->team->name }}</td>
                <td class="py-2 px-3">{{ $team->reason ?? '—' }}</td>
                <td class="py-2 px-3">
                    <form action="{{ route('banned-teams.destroy', $team) }}" method="POST" onsubmit="return confirm('Remove this team?');">
                        @csrf
                        @method('DELETE')
                        <button class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded">
                            Remove
                        </button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="4" class="py-3 text-center text-gray-500">No banned teams yet.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="mt-4">
        {{ $teams->links() }}
    </div>
</div>
@endsection
