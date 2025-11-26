@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto py-12 px-6">
    <div class="bg-white rounded-2xl shadow p-8">
        <h2 class="text-2xl font-bold">Create an account</h2>
        <p class="text-gray-500 mt-1">Step 1 of 3 — Personal info</p>

        <form action="{{ route('register.storeStep1') }}" method="POST" class="mt-6 space-y-4">
            @csrf

            <div>
                <label class="block text-sm font-medium text-gray-700">Full name</label>
                <input name="name" value="{{ old('name') }}" type="text" required
                       class="mt-1 block w-full rounded-md border-gray-200 shadow-sm focus:ring-orange-500 focus:border-orange-500">
                @error('name') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Email</label>
                <input name="email" value="{{ old('email') }}" type="email" required
                       class="mt-1 block w-full rounded-md border-gray-200 shadow-sm focus:ring-orange-500 focus:border-orange-500">
                @error('email') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Phone</label>
                    <input name="phone" value="{{ old('phone') }}" type="text" required
                           class="mt-1 block w-full rounded-md border-gray-200 shadow-sm focus:ring-orange-500 focus:border-orange-500">
                    @error('phone') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Institution</label>
                    <input name="institution" value="{{ old('institution') }}" type="text"
                           class="mt-1 block w-full rounded-md border-gray-200 shadow-sm focus:ring-orange-500 focus:border-orange-500">
                    @error('institution') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Education Level</label>
                <select name="education_level" required
                        class="mt-1 block w-full rounded-md border-gray-200 shadow-sm focus:ring-orange-500 focus:border-orange-500">
                    <option value="">Select</option>
                    <option value="grade6-8">Grade 6 - 8</option>
                    <option value="grade9-10">Grade 9 - 10 / SSC / equivalent</option>
                    <option value="grade11-12">Grade 11 - 12 / HSC / equivalent</option>
                    <option value="gap-year">Gap Year Student</option>
                </select>
                @error('education_level') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Password</label>
                <input name="password" type="password" required
                       class="mt-1 block w-full rounded-md border-gray-200 shadow-sm focus:ring-orange-500 focus:border-orange-500">
                @error('password') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Confirm Password</label>
                <input name="password_confirmation" type="password" required
                       class="mt-1 block w-full rounded-md border-gray-200 shadow-sm focus:ring-orange-500 focus:border-orange-500">
            </div>

            <div class="flex justify-between items-center mt-4">
                <a href="{{ route('landing') }}" class="text-sm text-gray-500 hover:text-orange-500">Back</a>
                <button type="submit" class="px-6 py-2 bg-orange-500 text-white rounded-lg font-semibold hover:bg-orange-600">
                    Continue to Tier
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
