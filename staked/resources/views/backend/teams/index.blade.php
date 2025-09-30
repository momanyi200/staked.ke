@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6" x-data="{ search: '' }">
    <h1 class="text-2xl font-bold mb-4">Teams Grouped by Country</h1>

    <a href="{{ route('teams.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded">+ Add Team</a>

    @if(session('success'))
        <div class="mt-4 bg-green-500 text-white p-3 rounded">
            {{ session('success') }}
        </div>
    @endif

    {{-- Alpine.js --}}
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

    <!-- 🔎 Search Bar -->
    <div class="mt-6 mb-4">
        <input type="text"
               x-model="search"
               placeholder="Search country..."
               class="w-full sm:w-1/2 px-4 py-2 border border-gray-500 rounded bg-gray-800 text-white focus:outline-none focus:ring focus:border-blue-400" />
    </div>

    @forelse($teamsByCountry as $countryName => $teams)
        <div 
            x-data="{ open: false }"
            x-show="search === '' || '{{ strtolower($countryName) }}'.includes(search.toLowerCase())"
            class="mt-6"
        >
            <!-- Country Header -->
            <button 
                @click="open = !open" 
                class="w-full flex justify-between items-center bg-gray-800 text-white px-4 py-2 rounded-t hover:bg-gray-700">
                <span class="text-xl font-semibold">{{ $countryName }}</span>
                <svg x-show="!open" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                     viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M12 4v16m8-8H4" />
                </svg>
                <svg x-show="open" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                     viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M20 12H4" />
                </svg>
            </button>

            <!-- Teams Table -->
            <div x-show="open" x-transition>
                <table class="w-full border-collapse border border-gray-700">
                    <thead>
                        <tr class="bg-gray-700 text-white">
                            <th class="border border-gray-600 px-4 py-2">#</th>
                            <th class="border border-gray-600 px-4 py-2">Name</th>
                            <th class="border border-gray-600 px-4 py-2">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($teams as $index => $team)
                            <tr class="hover:bg-gray-700 text-gray-200">
                                <td class="border border-gray-600 px-4 py-2">{{ $index + 1 }}</td>
                                <td class="border border-gray-600 px-4 py-2">{{ $team->name }}</td>
                                <td class="border border-gray-600 px-4 py-2">
                                    <a href="{{ route('teams.edit', $team) }}" class="text-blue-400 hover:underline">Edit</a>
                                    <form action="{{ route('teams.destroy', $team) }}" method="POST" class="inline">
                                        @csrf @method('DELETE')
                                        <button onclick="return confirm('Delete this team?')" class="text-red-400 hover:underline ml-2">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @empty
        <p class="mt-4 text-gray-300">No teams found.</p>
    @endforelse
</div>
@endsection
