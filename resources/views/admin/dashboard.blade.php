@extends('layouts.admin')

@section('content')
<div class="max-w-6xl mx-auto py-8">
    <h1 class="text-2xl font-bold mb-6">Welcome, Admin!</h1>

    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <div class="p-4 bg-white rounded shadow">
            <h3 class="font-semibold">Pending Registrations</h3>
            <p class="text-3xl mt-2">{{ $pendingRegistrations }}</p>
            <a href="{{ route('admin.registrations.index') }}" class="inline-block mt-3 text-sm px-3 py-1 bg-orange-500 text-white rounded">View →</a>
        </div>

        <div class="p-4 bg-white rounded shadow">
            <h3 class="font-semibold">Manage ECAs</h3>
            <p class="text-3xl mt-2">{{ $totalEcas }}</p>
            <a href="{{ route('admin.ecas.index') }}" class="inline-block mt-3 text-sm px-3 py-1 bg-orange-500 text-white rounded">Manage →</a>
        </div>

        <div class="p-4 bg-white rounded shadow">
            <h3 class="font-semibold">Pending Enrollments</h3>
            <p class="text-3xl mt-2">{{ $pendingEnrollments }}</p>
            <a href="{{ route('admin.enrollments.index') }}" class="inline-block mt-3 text-sm px-3 py-1 bg-orange-500 text-white rounded">View →</a>
        </div>

        <div class="p-4 bg-white rounded shadow">
            <h3 class="font-semibold">User Queries</h3>
            <p class="text-3xl mt-2">{{ $openQueries }}</p>
            <a href="{{ route('admin.queries.index') }}" class="inline-block mt-3 text-sm px-3 py-1 bg-orange-500 text-white rounded">Inbox →</a>
        </div>
    </div>
</div>
@endsection
