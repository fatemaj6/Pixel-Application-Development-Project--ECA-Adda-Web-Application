@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto py-12 px-6">
    <div class="bg-white rounded-2xl shadow p-8">
        <h2 class="text-2xl font-bold">Choose your subscription</h2>
        <p class="text-gray-500 mt-1">Step 2 of 3 — Subscription tier</p>

        <form action="{{ route('register.storeStep2') }}" method="POST" class="mt-6 space-y-4">
            @csrf

            <div class="grid gap-4 md:grid-cols-2">
                <label class="border rounded-lg p-4 cursor-pointer hover:shadow-lg group">
                    <input type="radio" name="package_type" value="tier1" class="hidden" required>
                    <div class="font-bold text-lg">Tier 1 — Premium</div>
                    <p class="text-gray-600 mt-1">Lifetime access + one-to-one sessions + personal mentorship</p>
                    <div class="mt-4 text-orange-500 font-semibold">Price: (To be added later)</div>
                </label>

                <label class="border rounded-lg p-4 cursor-pointer hover:shadow-lg group">
                    <input type="radio" name="package_type" value="tier2" class="hidden" required>
                    <div class="font-bold text-lg">Tier 2 — Standard</div>
                    <p class="text-gray-600 mt-1">Lifetime access to all ECAs (no 1:1 sessions)</p>
                    <div class="mt-4 text-orange-500 font-semibold">Price: (To be added later)</div>
                </label>
            </div>

            <div class="flex justify-between items-center mt-4">
                <a href="{{ route('register.step1') }}" class="text-sm text-gray-500 hover:text-orange-500">Back</a>
                <button type="submit" class="px-6 py-2 bg-orange-500 text-white rounded-lg font-semibold hover:bg-orange-600">
                    Continue to Payment
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
