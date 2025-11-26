@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto py-12 px-6">
    <div class="bg-white rounded-2xl shadow p-8">
        <h2 class="text-2xl font-bold">Payment & Complete</h2>
        <p class="text-gray-500 mt-1">Step 3 of 3 — Payment (Stripe sandbox will be integrated later)</p>

        <div class="mt-6">
            <p class="text-gray-700">Selected package:
                <strong class="text-orange-500">{{ strtoupper($data['package_type'] ?? 'tier2') }}</strong>
            </p>
            <p class="text-gray-600 mt-2">For now, click the button below to complete registration (payment integration will be added later).</p>

            <form action="{{ route('register.complete') }}" method="POST" class="mt-6">
                @csrf
                <button type="submit" class="px-6 py-2 bg-orange-500 text-white rounded-lg font-semibold hover:bg-orange-600">
                    Complete Registration (Skip Payment)
                </button>
            </form>
        </div>

        <div class="mt-6 text-sm text-gray-500">
            <p>When ready, we'll add Stripe sandbox integration and real payment flow.</p>
        </div>
    </div>
</div>
@endsection
