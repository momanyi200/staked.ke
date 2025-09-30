@extends('layouts.app')

@section('content')
    <h1 class="text-2xl font-semibold mb-4">New Ticket</h1>

    <form action="{{ route('tickets.store') }}" method="POST">
        @csrf

        <div class="mb-4">
            <label class="block text-sm font-medium">Ticket Number</label>
            <input type="text" name="ticket_number" class="w-full border rounded p-2 bg-gray-900 text-gray-200" required>
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium">Date</label>
            <input type="date" name="date" class="w-full border rounded p-2 bg-gray-900 text-gray-200" required>
        </div> 

        <div class="mb-4">
            <label class="block text-sm font-medium">Total Stake</label>
            <input type="number" step="0.01" name="total_stake" class="w-full border rounded p-2 bg-gray-900 text-gray-200" required>
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium">Total Odds</label>
            <input type="number" step="0.01" name="total_odds" class="w-full border rounded p-2 bg-gray-900 text-gray-200" required>
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium">Bonus (bonus awarded by your betting platform)</label>
            <input type="number" step="0.01" name="total_bonus" class="w-full border rounded p-2 bg-gray-900 text-gray-200" required>
        </div>    

        <h3 class="font-semibold mb-2">Bets</h3>
        <div id="bets-container">
            <div class="bet-item border p-3 mb-2 rounded">                
                <select name="bets[0][home_team_id]" class="border rounded p-2 w-full mb-2 bg-gray-900 text-gray-200" required>
                    <option value="">-- Select Home Team --</option>
                    @foreach($teams as $team)
                        <option value="{{ $team->id }}">{{ $team->name }} ({{ $team->country->name }})</option>
                    @endforeach
                </select>

                <select name="bets[0][away_team_id]" class="border rounded p-2 w-full mb-2 bg-gray-900 text-gray-200" required>
                    <option value="">-- Select Away Team --</option>
                    @foreach($teams as $team)
                        <option value="{{ $team->id }}">{{ $team->name }} ({{ $team->country->name }})</option>
                    @endforeach
                </select>

                <input type="text" name="bets[0][bet_type]" placeholder="Bet Type (e.g. Over 2.5)" class="border rounded p-2 w-full mb-2 bg-gray-900 text-gray-200" required>
                <input type="number" step="0.01" name="bets[0][odds]" placeholder="Odds" class="border rounded p-2 w-full mb-2 bg-gray-900 text-gray-200" required>
            </div>
        </div>

        <button type="button" onclick="addBet()" class="bg-gray-600 text-white px-3 py-1 rounded">+ Add Bet</button>

        <div class="mt-4">
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Save Ticket</button>
        </div>
    </form>

    <script>
        let betIndex = 1;

        function addBet() {
            const container = document.getElementById('bets-container');
            const div = document.createElement('div');
            div.classList.add('bet-item','border','p-3','mb-2','rounded');

            div.innerHTML = `
                <select name="bets[${betIndex}][home_team_id]" class="border rounded p-2 w-full mb-2 bg-gray-900 text-gray-200" required>
                    <option value="">-- Select Home Team --</option>
                    @foreach($teams as $team)
                        <option value="{{ $team->id }}">{{ $team->name }} ({{ $team->country->name }})</option>
                    @endforeach
                </select>

                <select name="bets[${betIndex}][away_team_id]" class="border rounded p-2 w-full mb-2 bg-gray-900 text-gray-200" required>
                    <option value="">-- Select Away Team --</option>
                    @foreach($teams as $team)
                        <option value="{{ $team->id }}">{{ $team->name }} ({{ $team->country->name }})</option>
                    @endforeach
                </select>

                <input type="text" name="bets[${betIndex}][bet_type]" placeholder="Bet Type (e.g. Over 2.5)" class="border rounded p-2 w-full mb-2 bg-gray-900 text-gray-200" required>
                <input type="number" step="0.01" name="bets[${betIndex}][odds]" placeholder="Odds" class="border rounded p-2 w-full mb-2 bg-gray-900 text-gray-200" required>
            `;

            container.appendChild(div);
            betIndex++;
        }
    </script>
@endsection
