@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-6 max-w-lg">
        <h1 class="text-xl font-bold mb-4">Edit Team</h1>

        <form method="POST" action="{{ route('teams.update', $team) }}" class="space-y-4">
            @csrf
            @method('PUT')

            <!-- Team Name -->
            <div>
                <label class="block text-gray-300">Team Name</label>
                <input type="text" name="name"
                    value="{{ old('name', $team->name) }}"
                    class="w-full p-2 rounded bg-gray-800 text-white"
                    required>
                @error('name')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Country -->
            <div>
                <label class="block text-gray-300">Country</label>
                <select name="country_id"
                        class="border rounded p-2 w-full mb-2 bg-gray-800 text-white"
                        required>
                    <option value="">-- Select country --</option>
                    @foreach($countries as $country)
                        <option value="{{ $country->id }}"
                            {{ old('country_id', $team->country_id) == $country->id ? 'selected' : '' }}>
                            {{ $country->name }} ({{ $country->code }})
                        </option>
                    @endforeach
                </select>
                @error('country_id')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <button class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                Update
            </button>
        </form>
    </div>

@endsection
