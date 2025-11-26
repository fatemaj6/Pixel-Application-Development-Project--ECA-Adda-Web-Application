@extends('layouts.app')

@section('content')
<div class="max-w-md mx-auto py-20 px-6">
    <div class="bg-white rounded-2xl shadow p-8">
        <h2 class="text-2xl font-bold text-gray-800">Admin OTP</h2>
        <p class="text-gray-500 mt-1">Enter the OTP sent to your admin email.</p>

        <form action="{{ route('admin.login.verify') }}" method="POST" class="mt-6 space-y-4">
            @csrf
            <div>
                <label class="block text-sm font-medium text-gray-700">OTP</label>
                <input name="otp" type="text" required maxlength="6"
                       class="mt-1 block w-full rounded-md border-gray-200 shadow-sm focus:ring-orange-500 focus:border-orange-500">
                @error('otp') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="flex justify-between items-center">
                <a href="{{ route('admin.login') }}" class="text-sm text-gray-500 hover:text-orange-500">Back</a>
                <button type="submit" class="px-6 py-2 bg-orange-500 text-white rounded-lg font-semibold hover:bg-orange-600">
                    Verify & Login
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
