@extends('layouts.app')

@section('content')
<div class="min-h-screen flex items-center justify-center">
    <div class="max-w-4xl w-full flex flex-col md:flex-row bg-zinc-900 rounded-lg shadow-lg overflow-hidden">

        <!-- Illustration Side -->
        <div class="hidden md:flex md:w-1/2 items-center justify-center bg-zinc-800 p-6">
            <img src="{{ asset('images/bet-tracker-login-illustration.png') }}"
                 alt="Bet Tracker Illustration"
                 class="max-w-full h-auto rounded-lg shadow-md">
        </div>

        <!-- Form Side -->
        <div class="w-full md:w-1/2 p-6">
            <h1 class="text-2xl font-semibold text-gray-200 text-center mb-6">Login</h1>
            <form action="{{ route('login') }}" method="POST">
                @csrf

                <!-- Email -->
                <div class="mb-4">
                    <label for="email" class="block text-gray-400 font-medium mb-2">Email Address</label>
                    <input type="email" id="email" name="email"
                        class="w-full bg-zinc-900 text-gray-200 border border-zinc-700 rounded-md p-3
                               focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="Enter your email" required>
                </div>

                <!-- Password -->
                <div class="mb-4">
                    <label for="password" class="block text-gray-400 font-medium mb-2">Password</label>
                    <input type="password" id="password" name="password"
                        class="w-full bg-zinc-900 text-gray-200 border border-zinc-700 rounded-md p-3
                               focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="Enter your password" required>
                </div>

                <!-- Remember Me -->
                <div class="mb-4 flex items-center">
                    <input type="checkbox" id="remember" name="remember"
                        class="text-blue-500 border-zinc-700 bg-zinc-900 focus:ring-2 focus:ring-blue-500 rounded">
                    <label for="remember" class="text-gray-400 ml-2">Remember me</label>
                </div>

                <!-- Submit Button -->
                <div class="mb-4">
                    <input type="submit" value="Login"
                        class="w-full bg-blue-500 text-white font-medium py-2 rounded-md
                               hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-300">
                    <a href="{{ route('register.form') }}"
                       class="block mt-2 text-center text-gray-300 hover:text-blue-400">
                       Create an account
                    </a>
                </div>

                <!-- Forgot Password -->
                <div class="text-center text-gray-400">
                    <a href="#" class="text-blue-400 hover:underline">Forgot your password?</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
