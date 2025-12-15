@extends('layouts.app')

@section('content')
<div class="max-w-lg mx-auto py-20 px-6">
    <div class="bg-white rounded-2xl shadow p-8">
        {{-- Success message (e.g. after registration) --}}
@if(session('success'))
    <div class="mb-4 p-3 bg-green-100 text-green-800 rounded-lg text-sm">
        {{ session('success') }}
    </div>
@endif

{{-- General error message --}}
@if(session('error'))
    <div class="mb-4 p-3 bg-red-100 text-red-800 rounded-lg text-sm">
        {{ session('error') }}
    </div>
@endif
        <h2 class="text-2xl font-bold text-gray-800">Login</h2>
        <p class="text-gray-500 mt-1">Enter your email to receive a one-time code (OTP).</p>

        <form action="{{ route('login.sendOtp') }}" method="POST" class="mt-6 space-y-4">
            @csrf
            <div>
                <label class="block text-sm font-medium text-gray-700">Email</label>
                <input name="email" value="{{ old('email') }}" type="email" required
                       class="mt-1 block w-full rounded-md border-gray-200 shadow-sm focus:ring-orange-500 focus:border-orange-500">
                @error('email') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
        <label class="block text-sm font-medium text-gray-700">Password</label>
        <input name="password" type="password" required
               class="mt-1 block w-full rounded-md border-gray-200 shadow-sm">
        @error('password') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
    </div>

    <div class="flex justify-between items-center">
        <a href="{{ route('password.request') }}"
           class="text-sm text-orange-600 hover:underline">
            Forgot password?
        </a>

        <button type="submit"
                class="px-6 py-2 bg-orange-500 text-white rounded-lg font-semibold">
            Login
        </button>
            </div>
        </form>

<div class="mt-4 text-center">
    <a href="{{ route('admin.login') }}" 
       class="inline-block px-4 py-2 border border-gray-600 text-gray-700 rounded-lg 
              hover:bg-gray-100 transition">
        Admin Login
    </a>
</div>

    </div>
</div>
@endsection