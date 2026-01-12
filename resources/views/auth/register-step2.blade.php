@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto py-12 px-6">
    <div class="bg-white rounded-2xl shadow p-8">
        <h2 class="text-2xl font-bold">Choose your subscription</h2>
        <p class="text-gray-500 mt-1">Step 2 of 2 - Subscription tier</p>

        <form action="{{ route('register.storeStep2', [], false) }}" method="POST" class="mt-6 space-y-4">
            @csrf

            <div class="grid gap-4 md:grid-cols-2">
                <div>
                    <input id="tier1" type="radio" name="package_type" value="tier1" class="peer sr-only" required>
                    <label for="tier1" class="block border rounded-lg p-4 cursor-pointer transition hover:shadow-lg peer-checked:border-orange-500 peer-checked:bg-orange-50 peer-checked:ring-2 peer-checked:ring-orange-500">
                        <div class="font-bold text-lg">Tier 1 - Standard</div>
                        <p class="text-gray-600 mt-1">Lifetime access to all ECAs (no 1:1 sessions)</p>
                        <div class="mt-4 text-orange-500 font-semibold">Price: BDT 700tk</div>
                    </label>
                </div>

                <div>
                    <input id="tier2" type="radio" name="package_type" value="tier2" class="peer sr-only" required>
                    <label for="tier2" class="block border rounded-lg p-4 cursor-pointer transition hover:shadow-lg peer-checked:border-orange-500 peer-checked:bg-orange-50 peer-checked:ring-2 peer-checked:ring-orange-500">
                        <div class="font-bold text-lg">Tier 2 - Premium</div>
                        <p class="text-gray-600 mt-1">Lifetime access + one-to-one sessions + personal mentorship</p>
                        <div class="mt-4 text-orange-500 font-semibold">Price: BDT 1000tk</div>
                    </label>
                </div>
            </div>

            <div class="flex justify-between items-center mt-4">
                <a href="{{ route('register.step1', [], false) }}" class="text-sm text-gray-500 hover:text-orange-500">Back</a>
                <button type="submit" class="px-6 py-2 bg-orange-500 text-white rounded-lg font-semibold hover:bg-orange-600">
                    Continue to Payment
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
