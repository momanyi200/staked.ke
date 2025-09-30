@extends('layouts.app')

@section('content')
    <h1 class="text-2xl font-bold text-gray-200 mb-4">Ban a Team</h1>

    @if ($errors->any())
        <div class="bg-red-600 text-white p-2 rounded mb-4">
            <ul class="list-disc pl-4">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('banned-teams.store') }}" method="POST" class="bg-zinc-800 p-6 rounded-lg shadow">
        @csrf
        <div class="mb-4">
            <label for="name" class="block text-gray-300 mb-1">Team Name</label>            
            <select name="team_id" class="border rounded p-2 w-full mb-2 bg-gray-900 text-gray-200" required>
                <option value="">-- Select Team --</option>
                @foreach($teams as $team)
                    <option value="{{ $team->id }}">{{ $team->name }}  -- {{$team->country->name}} </option>
                @endforeach
            </select>    
        </div> 
        <div class="mb-4">
            <label for="reason" class="block text-gray-300 mb-1">Reason (optional)</label>
            <textarea name="reason" id="reason" rows="3"
                    class="w-full px-3 py-2 rounded bg-zinc-900 border border-zinc-700 text-gray-200 focus:ring-2 focus:ring-green-500">{{ old('reason') }}</textarea>
        </div>
        <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded">
            Save
        </button>
    </form>
@endsection
