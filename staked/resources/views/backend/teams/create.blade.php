@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6 max-w-lg">
    <h1 class="text-xl font-bold mb-4">Add Team</h1>

    <form method="POST" action="{{ route('teams.store') }}" class="space-y-4">
        @csrf 
        <div>
            <label class="block text-gray-300">Team Name</label>
            <input type="text" name="name" class="w-full p-2 rounded bg-gray-800 text-white" required>
        </div>

        <div>
            <label class="block text-gray-300">Country</label>           
            <select name="country_id" class="border rounded p-2 w-full mb-2 bg-gray-800 text-white" required>
                    <option value="">-- Select country --</option>
                    @foreach($countries as $country)
                        <option value="{{ $country->id }}">{{ $country->name }} ({{ $country->code }})</option>
                    @endforeach
                </select>
        </div>

        <button class="bg-green-600 text-white px-4 py-2 rounded">Save</button>
    </form>
</div> 
@endsection
