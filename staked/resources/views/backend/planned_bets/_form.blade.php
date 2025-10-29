<div 
    x-data="matchTeams({
        teams: @js($teams),
        homeSelected: '{{ old('home_team_id', $plannedBet->home_team_id ?? '') }}',
        awaySelected: '{{ old('away_team_id', $plannedBet->away_team_id ?? '') }}'
    })"
    class="grid grid-cols-1 md:grid-cols-2 gap-4"
>
    <!-- Home Team -->
    <div class="relative w-full">
        <label class="block text-sm font-medium mb-1 text-gray-200">Home Team</label>

        <div class="relative">
            <input type="hidden" name="home_team_id" :value="homeSelected">

            <input 
                type="text"
                x-model="homeSearch"
                @focus="homeOpen = true"
                @click.away="homeOpen = false"
                placeholder="Search or select a team..."
                class="w-full bg-gray-700 text-white rounded p-2 border border-gray-600 focus:outline-none focus:ring-2 focus:ring-green-600"
            >

            <div 
                x-show="homeOpen"
                x-transition
                class="absolute z-50 mt-1 w-full bg-gray-800 border border-gray-700 rounded shadow-lg max-h-48 overflow-y-auto"
            >
                <template x-for="team in filteredHomeTeams" :key="team.id">
                    <div 
                        @click="selectHome(team)"
                        class="px-3 py-2 cursor-pointer hover:bg-gray-700 text-gray-200"
                        x-text="team.name"
                    ></div>
                </template>

                <div 
                    x-show="filteredHomeTeams.length === 0"
                    class="px-3 py-2 text-gray-400 text-sm"
                >
                    No team found.
                </div>
            </div>
        </div>

        @error('home_team_id') 
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p> 
        @enderror
    </div>

    <!-- Away Team -->
    <div class="relative w-full">
        <label class="block text-sm font-medium mb-1 text-gray-200">Away Team</label>

        <div class="relative">
            <input type="hidden" name="away_team_id" :value="awaySelected">

            <input 
                type="text"
                x-model="awaySearch"
                @focus="awayOpen = true"
                @click.away="awayOpen = false"
                placeholder="Search or select a team..."
                class="w-full bg-gray-700 text-white rounded p-2 border border-gray-600 focus:outline-none focus:ring-2 focus:ring-green-600"
            >

            <div 
                x-show="awayOpen"
                x-transition
                class="absolute z-50 mt-1 w-full bg-gray-800 border border-gray-700 rounded shadow-lg max-h-48 overflow-y-auto"
            >
                <template x-for="team in filteredAwayTeams" :key="team.id">
                    <div 
                        @click="selectAway(team)"
                        class="px-3 py-2 cursor-pointer hover:bg-gray-700 text-gray-200"
                        x-text="team.name"
                    ></div>
                </template>

                <div 
                    x-show="filteredAwayTeams.length === 0"
                    class="px-3 py-2 text-gray-400 text-sm"
                >
                    No team found.
                </div>
            </div>
        </div>

        @error('away_team_id') 
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p> 
        @enderror
    </div>
</div>
