<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Bet Tracker</title>
        <link rel="icon" type="image/x-icon" href="/images/favicon.ico">
        <!-- Fonts and Icons -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
        

        <!-- Tailwind and Alpine.js -->
        <script src="https://cdn.tailwindcss.com"></script>
        <script src="//unpkg.com/alpinejs" defer></script>

        <!-- FullCalendar CSS -->
        <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.9/main.min.css" rel="stylesheet" />

        <!-- FullCalendar JS -->
        <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.9/main.min.js"></script>

        
    </head>
    <body class="bg-gray-900 text-gray-100 min-h-screen">
        
        <nav x-data="{ open: false }" class="bg-gray-800 shadow-md">
            <div class="max-w-7xl mx-auto px-4 py-3 flex justify-between items-center">
                <!-- Logo -->
                <div class="flex items-center">
                    <a href="/" class="flex items-center space-x-2">
                        <img src="/images/bet_tracker_logo.png" alt="Bet Tracker Logo" class="h-8 w-auto">
                        <span class="text-xl font-bold text-green-700">Bet Tracker</span>
                    </a>
                </div>

                <!-- Main Menu -->
                <div class="hidden md:flex space-x-4 items-center">
                    @guest
                        <a href="{{ route('login.form') }}" class="text-gray-200 hover:text-green-300">Login</a>
                        <a href="{{ route('register.form') }}" class="text-gray-200 hover:text-green-300">Register</a>
                    @endguest

                    @auth
                        

                        <!-- Plannedbet Dropdown -->
                        <div x-data="{ openTickets: false }" class="relative">
                            <button @click="openTickets = !openTickets" class="hover:text-green-300 focus:outline-none">
                                Playground ▾
                            </button>
                            <div x-show="openTickets" @click.away="openTickets = false"
                                class="absolute bg-gray-700 rounded shadow-lg mt-2 min-w-[180px] z-50">
                                <a href="{{ route('planned-bets.index') }}" class="block px-4 py-2 hover:bg-gray-600">Planned Bet</a>
                                <a href="{{ route('planned-bets.create') }}" class="block px-4 py-2 hover:bg-gray-600">Add Planned Bet</a>
                            </div>
                        </div>

                         <!-- Ticket Dropdown -->
                        <div x-data="{ openTickets: false }" class="relative">
                            <button @click="openTickets = !openTickets" class="hover:text-green-300 focus:outline-none">
                                Tickets ▾
                            </button>
                            <div x-show="openTickets" @click.away="openTickets = false"
                                class="absolute bg-gray-700 rounded shadow-lg mt-2 min-w-[180px] z-50">
                                <a href="{{ route('tickets.index') }}" class="block px-4 py-2 hover:bg-gray-600">Tickets</a>
                                <a href="{{ route('tickets.create') }}" class="block px-4 py-2 hover:bg-gray-600">New Ticket</a>
                            </div>
                        </div>

                        <!-- Teams Dropdown -->
                        <div x-data="{ openTeams: false }" class="relative">
                            <button @click="openTeams = !openTeams" class="hover:text-green-300 focus:outline-none">
                                Teams ▾
                            </button>
                            <div x-show="openTeams" @click.away="openTeams = false"
                                class="absolute bg-gray-700 rounded shadow-lg mt-2 min-w-[180px] z-50">
                                <a href="{{ route('teams.index') }}" class="block px-4 py-2 hover:bg-gray-600">All Teams</a>
                                <a href="{{ route('review.teams') }}" class="block px-4 py-2 hover:bg-gray-600">Review Teams</a>
                                <a href="{{ route('banned-teams.index') }}" class="block px-4 py-2 hover:bg-gray-600">Banned Teams</a>
                            </div>
                        </div>

                        <a href="{{ route('journals.index') }}" class="hover:text-green-300">Journal</a>

                        <!-- Account Dropdown -->
                        <div x-data="{ openAcc: false }" class="relative">
                            <button @click="openAcc = !openAcc" class="hover:text-green-300 focus:outline-none">
                               
                                <i class='bx  bx-user'  ></i> 
                            </button>
                            <div x-show="openAcc" @click.away="openAcc = false"
                                class="absolute bg-gray-700 rounded shadow-lg mt-2 min-w-[180px] z-50">
                                <span class="block px-4 py-2 hover:bg-gray-600">Hi, {{ Auth::user()->name }}</span>
                                <a href="{{ route('dashboard') }}" class="block px-4 py-2 hover:bg-gray-600">Dashboard</a>
                                <a href="{{ route('wallet.index') }}" class="block px-4 py-2 hover:bg-gray-600">Wallet</a>
                                <form action="{{ route('logout') }}" method="POST" class="block">
                                    @csrf
                                    <button type="submit" class="w-full text-left px-4 py-2 hover:bg-gray-600">Logout</button>
                                </form>
                            </div>
                        </div>

                        
                    @endauth
                </div>

                <!-- Mobile Toggle -->
                <button @click="open = !open" class="md:hidden text-gray-200 focus:outline-none">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>
            </div>

            <!-- Mobile Menu -->
            <div x-show="open" class="md:hidden px-4 pb-3 space-y-2">
                @guest
                    <a href="{{ route('login.form') }}" class="block text-gray-200 hover:text-green-300">Login</a>
                    <a href="{{ route('register.form') }}" class="block text-gray-200 hover:text-green-300">Register</a>
                @endguest

                @auth
                    

                     <!-- Teams Dropdown -->
                        <div x-data="{ openTicketM: false }" class="relative">
                            <button @click="openTicketM = !openTicketM" class="hover:text-green-300 focus:outline-none">
                                Ticket ▾
                            </button>
                            <div x-show="openTicketM" @click.away="openTicketM = false"
                                class="absolute bg-gray-700 rounded shadow-lg mt-2 min-w-[180px] z-50">
                                <a href="{{ route('tickets.index') }}" class="block px-4 py-2 hover:bg-gray-600">Tickets</a>
                                <a href="{{ route('tickets.create') }}" class="block px-4 py-2 hover:bg-gray-600">New Ticket</a>
                                
                            </div>
                        </div>

                    <!-- Teams dropdown (mobile) -->
                    <div x-data="{ openTeamsM: false }">
                        <button @click="openTeamsM = !openTeamsM" class="block w-full text-left hover:text-green-300">
                            Teams ▾
                        </button>
                        <div x-show="openTeamsM" class="ml-4 space-y-1">
                            <a href="{{ route('teams.index') }}" class="block hover:text-green-300">All Teams</a>
                            <a href="{{ route('review.teams') }}" class="block hover:text-green-300">Review Teams</a>
                            <a href="{{ route('banned-teams.index') }}" class="block hover:text-green-300">Banned Teams</a>
                        </div>
                    </div>

                    <a href="{{ route('journals.index') }}" class="block hover:text-green-300">Journal</a>

                    <!-- Account dropdown (mobile) -->
                    <div x-data="{ openAccM: false }">
                        <button @click="openAccM = !openAccM" class="block w-full text-left hover:text-green-300">
                            <i class='bx  bx-user'  ></i>  ▾
                        </button>
                        <div x-show="openAccM" class="ml-4 space-y-1">

                            <span class="block px-4 py-2 hover:bg-gray-600">Hi, {{ Auth::user()->name }}</span>
                            <a href="{{ route('wallet.index') }}" class="block hover:text-green-300">Wallet</a>
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="w-full text-left hover:text-green-300">Logout</button>
                            </form>
                        </div>
                    </div>
                   
                @endauth
            </div>
        </nav>



 
      
        <main class="max-w-6xl mx-auto px-4 py-6">
            @include('alerts.alerts')
            @yield('content')
        </main>

        
        <!-- Alpine component -->
        <script>
            function matchTeams({ teams, homeSelected, awaySelected }) {
                return {
                    teams,
                    homeSelected,
                    awaySelected,
                    homeSearch: '',
                    awaySearch: '',
                    homeOpen: false,
                    awayOpen: false,

                    init() {
                        const home = this.teams.find(t => t.id == this.homeSelected);
                        const away = this.teams.find(t => t.id == this.awaySelected);
                        if (home) this.homeSearch = home.name;
                        if (away) this.awaySearch = away.name;
                    },

                    get filteredHomeTeams() {
                        return this.teams.filter(
                            t => t.name.toLowerCase().includes(this.homeSearch.toLowerCase()) &&
                                t.id != this.awaySelected
                        );
                    },

                    get filteredAwayTeams() {
                        return this.teams.filter(
                            t => t.name.toLowerCase().includes(this.awaySearch.toLowerCase()) &&
                                t.id != this.homeSelected
                        );
                    },

                    selectHome(team) {
                        this.homeSelected = team.id;
                        this.homeSearch = team.name;
                        this.homeOpen = false;
                    },

                    selectAway(team) {
                        this.awaySelected = team.id;
                        this.awaySearch = team.name;
                        this.awayOpen = false;
                    },
                }
            }
        </script>

    </body>
</html>