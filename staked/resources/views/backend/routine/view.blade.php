@extends('layouts.app')

@section('content')
    <div class="bg-gray-900 text-white p-6 rounded-xl shadow-lg mt-6">
        <h2 class="text-2xl font-semibold mb-4">🎯 Pre-Bet Routine</h2>
        <ul class="space-y-3 list-disc list-inside text-gray-300">
            @foreach($routines as $routine)
                <li>{{ $routine->title }} — {{ $routine->description }}</li>
            @endforeach
        </ul>

        <h2 class="text-2xl font-semibold mt-8 mb-4">⚖️ Betting Rules</h2>
        <ul class="space-y-3 list-disc list-inside text-gray-300">
            @foreach($rules as $rule)
                <li>{{ $rule->title }} — {{ $rule->description }}</li>
            @endforeach
        </ul>

        <div class="mt-6 flex justify-center">
            <label class="flex items-center space-x-2 cursor-pointer">
                <input type="checkbox" id="routineChecked" name="routineChecked" class="rounded text-green-500 focus:ring-green-600">
                <span class="text-sm text-gray-400">I have followed the above checklist</span>
            </label>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const form = document.querySelector('form');
            const checkbox = document.querySelector('#routineChecked');
            if (form && checkbox) {
                form.addEventListener('submit', (e) => {
                    if (!checkbox.checked) {
                        e.preventDefault();
                        alert('Please confirm you’ve followed your pre-bet routine first ✅');
                    }
                });
            }
        });
    </script>
@endsection
