@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto py-8">
    <h2 class="text-xl font-bold mb-4">Registration: {{ $user->name }}</h2>

    <div class="bg-white p-6 rounded shadow">
        <dl class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div><dt class="font-semibold">Name</dt><dd>{{ $user->name }}</dd></div>
            <div><dt class="font-semibold">Email</dt><dd>{{ $user->email }}</dd></div>
            <div><dt class="font-semibold">Phone</dt><dd>{{ $user->phone ?? '-' }}</dd></div>
            <div><dt class="font-semibold">Institution</dt><dd>{{ $user->institution ?? '-' }}</dd></div>
            <div><dt class="font-semibold">Education Level</dt><dd>{{ $user->education_level ?? '-' }}</dd></div>
            <div><dt class="font-semibold">Package</dt><dd>{{ $user->package_type ?? 'tier2' }}</dd></div>
            <div><dt class="font-semibold">Payment Status</dt><dd>{{ $user->payment_status ?? '-' }}</dd></div>
            <div><dt class="font-semibold">Registered At</dt><dd>{{ $user->created_at }}</dd></div>
        </dl>

        <div class="mt-6 flex gap-2">
            <form action="{{ route('admin.registrations.approve', $user) }}" method="POST" onsubmit="return confirm('Approve this registration?');">
                @csrf
                <button class="px-3 py-2 bg-green-600 text-white rounded">Approve</button>
            </form>

            <!-- Request correction modal: simple form -->
            <form action="{{ route('admin.registrations.correction', $user) }}" method="POST" onsubmit="return confirm('Send correction request?');">
                @csrf
                <input type="text" name="notes" placeholder="Short note for user" required class="px-2 py-1 border rounded">
                <button class="px-3 py-2 bg-yellow-500 text-white rounded">Ask for Correction</button>
            </form>

            <form action="{{ route('admin.registrations.reject', $user) }}" method="POST" onsubmit="return confirm('Reject and trigger refund?');">
                @csrf
                <input type="hidden" name="notes" value="Rejected by admin">
                <button class="px-3 py-2 bg-red-600 text-white rounded">Reject & Refund</button>
            </form>
        </div>
    </div>
</div>
@endsection
