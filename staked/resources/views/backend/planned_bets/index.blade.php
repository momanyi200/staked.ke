@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-semibold text-white">Planned Bets</h1>
        <a href="{{ route('planned-bets.create') }}" 
           class="px-4 py-2 bg-green-600 hover:bg-green-500 text-white rounded">
           + Add Planned Bet
        </a>
    </div>

    {{-- Success Message --}}
    @if(session('success'))
        <div class="mb-4 bg-green-700 text-green-100 p-3 rounded">
            {{ session('success') }}
        </div>
    @endif

    {{-- Filters --}}
    <form method="GET" action="{{ route('planned-bets.index') }}" class="mb-6 bg-gray-900 p-4 rounded-lg">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            {{-- Search by Team/Prediction --}}
            <div>
                <input type="text" name="search" value="{{ request('search') }}"
                    placeholder="Search by team or prediction..."
                    class="w-full px-3 py-2 bg-gray-800 border border-gray-700 rounded text-gray-200 focus:ring-2 focus:ring-blue-600 focus:outline-none">
            </div>

            {{-- Status Filter --}}
            <div>
                <select name="status" onchange="this.form.submit()"
                    class="w-full px-3 py-2 bg-gray-800 border border-gray-700 rounded text-gray-200 focus:ring-2 focus:ring-blue-600 focus:outline-none">
                    <option value="">All Statuses</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="decided" {{ request('status') == 'decided' ? 'selected' : '' }}>Decided</option>
                    <option value="discarded" {{ request('status') == 'discarded' ? 'selected' : '' }}>Discarded</option>
                    <option value="moved" {{ request('status') == 'moved' ? 'selected' : '' }}>Moved</option>
                    <option value="expired" {{ request('status') == 'expired' ? 'selected' : '' }}>Expired</option>

                </select>
            </div>

            {{-- From Date --}}
            <div>
                <input type="date" name="from" value="{{ request('from') }}"
                    class="w-full px-3 py-2 bg-gray-800 border border-gray-700 rounded text-gray-200 focus:ring-2 focus:ring-blue-600 focus:outline-none"
                    onchange="this.form.submit()">
            </div>

            {{-- To Date --}}
            <div>
                <input type="date" name="to" value="{{ request('to') }}"
                    class="w-full px-3 py-2 bg-gray-800 border border-gray-700 rounded text-gray-200 focus:ring-2 focus:ring-blue-600 focus:outline-none"
                    onchange="this.form.submit()">
            </div>
        </div>

        <div class="mt-3 flex justify-end">
            <button type="submit" class="px-4 py-2 bg-blue-600 hover:bg-blue-500 text-white rounded">
                Filter
            </button>
            @if(request()->hasAny(['search','status','from','to']))
                <a href="{{ route('planned-bets.index') }}" 
                   class="ml-3 px-4 py-2 bg-gray-600 hover:bg-gray-500 text-white rounded">
                   Clear
                </a>
            @endif
        </div>
    </form>

    {{-- Table --}}
    <div class="bg-gray-800 shadow-md rounded-lg overflow-hidden">
        <table class="min-w-full text-left text-gray-300">
            <thead class="bg-gray-900 text-gray-200 uppercase text-sm">
                <tr>
                    <th class="px-4 py-3">#</th>
                    <th class="px-4 py-3">Match</th>
                    <th class="px-4 py-3">Prediction</th>
                    <th class="px-4 py-3">Odd</th>
                    <th class="px-4 py-3">Match Date</th>
                    <th class="px-4 py-3">Status</th>
                    <th class="px-4 py-3 text-right">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($plannedBets as $index => $planned)
                    <tr class="border-t border-gray-700 hover:bg-gray-700/50">
                        <td class="px-4 py-2">{{ $index + 1 }}</td>
                        <td class="px-4 py-2">
                            <span class="font-semibold text-gray-100">{{ $planned->homeTeam->name }}</span>
                            <span class="text-gray-400">vs</span>
                            <span class="font-semibold text-gray-100">{{ $planned->awayTeam->name }}</span>
                        </td>
                        <td class="px-4 py-2">{{ $planned->prediction ?? '-' }}</td>
                        <td class="px-4 py-2 text-gray-100">{{ $planned->odd ?? '-' }}</td>
                        <td class="px-4 py-2">
                            {{ $planned->match_date ? \Carbon\Carbon::parse($planned->match_date)->format('d M, H:i') : '-' }}
                        </td>
                        <td class="px-4 py-2">
                            
                            @php
                                $colors = [
                                    'pending' => 'bg-yellow-600',
                                    'decided' => 'bg-blue-600',
                                    'discarded' => 'bg-red-600',
                                    'moved' => 'bg-green-600',
                                    'expired' => 'bg-gray-500',
                                ];
                            @endphp

                            <span class="px-2 py-1 rounded text-xs text-white {{ $colors[$planned->status] ?? 'bg-gray-600' }}">
                                {{ ucfirst($planned->status) }}
                            </span>
                        </td>
                        <td class="px-4 py-2 text-right">
                            <div class="flex justify-end space-x-2">
                                <a href="{{ route('planned-bets.show', $planned->id) }}" 
                                    class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1 rounded text-sm">
                                    View
                                </a>
                                <a href="{{ route('planned-bets.edit', $planned->id) }}" 
                                   class="px-2 py-1 text-sm bg-blue-600 hover:bg-blue-500 text-white rounded">
                                    Edit
                                </a>
                                <form action="{{ route('planned-bets.destroy', $planned) }}" method="POST" onsubmit="return confirm('Delete this planned bet?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="px-2 py-1 text-sm bg-red-600 hover:bg-red-500 text-white rounded">
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center text-gray-400 py-6">No planned bets found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
