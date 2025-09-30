<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Bet Tracker</title>

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
        
       <nav class="bg-gray-800 shadow-md">
            <div class="max-w-7xl mx-auto px-4 py-3 flex justify-between items-center">
               
                <!-- Logo -->
                <div class="flex items-center">
                    <a href="/" class="flex items-center space-x-2">
                        <img src="/images/bet_tracker_logo.png" alt="Bet Tracker Logo" class="h-8 w-auto">
                        <span class="text-xl font-bold text-green-700">Bet Tracker</span>
                    </a>
                </div>

                <div class="space-x-4 flex items-center">
                    @guest
                        <a href="{{ route('login.form') }}" class="text-gray-200 hover:text-green-300">Login</a>
                        <a href="{{ route('register.form') }}" class="text-gray-200 hover:text-green-300">Register</a>
                    @endguest

                    @auth

                        
                        <a href="{{ route('tickets.index') }}" class="hover:text-green-300">Tickets</a>
                        <a href="{{ route('tickets.create') }}" class="hover:text-green-300">New Ticket</a>
                        <a href="{{ route('banned-teams.index') }}" class="hover:text-green-300">Banned Teams</a>
                        <a href="{{ route('teams.index') }}" class="hover:text-green-300">Teams</a>
                        <a href="{{ route('wallet.index') }}" class="hover:text-green-300">Wallet</a>
                        <a href="{{ route('journals.index') }}" class="hover:text-green-300">Journal</a>

                        <span class="text-gray-300">Hi, {{ Auth::user()->name }}</span>
                        <form action="{{ route('logout') }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" aria-label="Logout"
                                    class="text-gray-200 hover:text-green-300 focus:outline-none">
                                Logout
                            </button>
                        </form>
                    @endauth
                </div>
            </div>
       </nav>


 
      
        <main class="max-w-6xl mx-auto px-4 py-6">
            @include('alerts.alerts')
            @yield('content')
        </main>
    </body>
</html>