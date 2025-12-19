@extends('layouts.app')

@section('content')
<div class="max-w-md mx-auto py-20">

    <h2 class="text-3xl font-bold text-center mb-6 text-orange-500">
        Admin Login
    </h2>

    @if ($errors->any())
        <div class="mb-4 bg-red-100 text-red-700 p-3 rounded">
            {{ $errors->first() }}
        </div>
    @endif

    <form method="POST" action="{{ route('admin.login.post') }}"
          class="bg-white shadow-lg rounded-lg p-6 border border-gray-100">

        @csrf

        <label class="block font-semibold mb-2">Admin Email:</label>
        <input type="email" name="email"
               value="{{ old('email') }}"
               class="w-full border rounded p-2 mb-4 focus:ring-2 focus:ring-orange-400"
               required>

        <div>
        <label class="block text-sm font-medium text-gray-700">Password</label>
        <input name="password" type="password" required
               class="mt-1 block w-full rounded-md border-gray-200 shadow-sm">
        @error('password') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
    </div>

        <button class="w-full bg-orange-500 text-white py-2 rounded-lg
                       hover:bg-orange-600 transition duration-200">
            Send OTP
        </button>

    </form>

</div>
@endsection
