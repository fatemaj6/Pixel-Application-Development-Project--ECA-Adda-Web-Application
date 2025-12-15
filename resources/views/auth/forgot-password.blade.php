@extends('layouts.app')

@section('content')
<div class="max-w-md mx-auto py-20 px-6">
    <div class="bg-white rounded-2xl shadow p-8">
        <h2 class="text-2xl font-bold text-gray-800">Forgot Password</h2>
        <p class="text-gray-500 mt-1">
            Enter your email and we’ll send you a password reset link.
        </p>

        @if (session('status'))
            <p class="mt-4 text-sm text-green-600">
                {{ session('status') }}
            </p>
        @endif

        <form action="{{ route('password.email') }}" method="POST" class="mt-6 space-y-4">
            @csrf

            <div>
                <label class="block text-sm font-medium text-gray-700">Email</label>
                <input name="email" type="email" value="{{ old('email') }}" required
                       class="mt-1 block w-full rounded-md border-gray-200 shadow-sm 
                              focus:ring-orange-500 focus:border-orange-500">
                @error('email')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex justify-between items-center">
                <a href="{{ route('login') }}"
                   class="text-sm text-gray-500 hover:text-orange-500">
                    Back to login
                </a>

                <button type="submit"
                        class="px-6 py-2 bg-orange-500 text-white rounded-lg font-semibold 
                               hover:bg-orange-600">
                    Send Reset Link
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
