@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto py-12 px-6">
    <div class="bg-white rounded-2xl shadow p-8">
        <h2 class="text-2xl font-bold">Confirm your plan</h2>
        <p class="text-gray-500 mt-1">Step 3 of 3 - Confirm & Pay</p>

        <div class="mt-6 space-y-2">
            <p class="text-gray-700">
                Selected package:
                <strong class="text-orange-500">
                    {{ $data['package_type'] === 'tier1' ? 'Tier 1 - Standard' : 'Tier 2 - Premium' }}
                </strong>
            </p>
            <p class="text-gray-700">
                Amount to pay:
                <strong class="text-orange-500">BDT {{ $amount }}</strong>
            </p>
            <p class="text-gray-600">You will be redirected to Stripe to complete payment.</p>
        </div>

        <div class="mt-6 flex flex-col-reverse gap-3 sm:flex-row sm:items-center sm:justify-between">
            <a href="{{ route('register.step2', [], false) }}" class="inline-flex items-center justify-center rounded-lg border border-gray-300 px-4 py-2 text-gray-700 hover:border-orange-500 hover:text-orange-500">
                Back
            </a>

            <form action="{{ route('register.complete', [], false) }}" method="POST">
                @csrf
                <button class="inline-flex items-center justify-center rounded-lg bg-orange-500 px-6 py-2 font-semibold text-white hover:bg-orange-600">
                    Pay with Stripe
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
