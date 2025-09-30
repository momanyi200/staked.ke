
@extends('layouts.app')

@section('content')
    <div class="min-h-screen flex items-center justify-center"> 

        <div class="w-full max-w-md bg-zinc-900 p-6 rounded-lg shadow-md mx-auto"> 
            <h1 class="text-2xl font-bold mb-6 text-gray-700 text-center">Create New Account</h1>
            <form action="{{ route('register') }}" method="POST"> 
                @csrf 

                <!-- Name Field -->
                <div class="mb-4">
                    <label for="name" class="block text-gray-600 font-medium mb-2">Name</label>
                    <input type="text" name="name" id="name" 
                        class="w-full bg-zinc-900 px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('name') border-red-500 @enderror" 
                        value="{{ old('name') }}"
                            required>
                    @error('name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email Field -->
                <div class="mb-4">
                    <label for="email" class="block text-gray-600 font-medium mb-2">Email Address</label>
                    <input type="email" name="email" id="email" 
                        class="w-full bg-zinc-900 px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('email') border-red-500 @enderror" 
                        value="{{ old('email') }}" required>
                    @error('email')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password Field -->
                <div class="mb-4">
                    <label for="password" class="block text-gray-600 font-medium mb-2">Password</label>
                    <input type="password" name="password" id="password" 
                        class="w-full bg-zinc-900 px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('password') border-red-500 @enderror" 
                        required>
                    @error('password')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Confirm Password Field -->
                <div class="mb-4">
                    <label for="password_confirmation" class="block text-gray-600 font-medium mb-2">Confirm Password</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" 
                        class="w-full bg-zinc-900 px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" 
                        required>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="w-full bg-blue-500 text-white py-2 rounded-lg hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-300">
                    Create Acc
                </button>
            </form>
        </div>

    </div>

@endsection

