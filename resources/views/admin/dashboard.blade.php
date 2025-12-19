@extends('layouts.admin')

@section('content')
<div class="max-w-7xl mx-auto px-6">
    <div class="flex flex-col gap-2 mb-8">
        <p class="text-sm uppercase tracking-[0.3em] text-gray-400">Overview</p>
        <h1 class="text-3xl font-semibold text-gray-900">Welcome, Admin!</h1>
        <p class="text-gray-600">Here’s a quick summary of today’s activity.</p>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-6">
        <div class="p-6 bg-white rounded-lg shadow-sm border border-gray-200">
            <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wide">Pending Registrations</h3>
            <p class="text-3xl font-semibold text-gray-900 mt-3">{{ $pendingRegistrations }}</p>
            <p class="text-sm text-gray-500 mt-2">Review new students awaiting approval.</p>
            <a href="{{ route('admin.registrations.index') }}" class="inline-flex items-center gap-2 mt-4 text-sm font-medium text-orange-600 hover:text-orange-700">
                View registrations <span aria-hidden="true">→</span>
            </a>
        </div>

        <div class="p-6 bg-white rounded-lg shadow-sm border border-gray-200">
            <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wide">Manage ECAs</h3>
            <p class="text-3xl font-semibold text-gray-900 mt-3">{{ $totalEcas }}</p>
            <p class="text-sm text-gray-500 mt-2">Create and update activity offerings.</p>
            <a href="{{ route('admin.ecas.index') }}" class="inline-flex items-center gap-2 mt-4 text-sm font-medium text-orange-600 hover:text-orange-700">
                Manage ECAs <span aria-hidden="true">→</span>
            </a>
        </div>

        <div class="p-6 bg-white rounded-lg shadow-sm border border-gray-200">
            <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wide">Pending Enrollments</h3>
            <p class="text-3xl font-semibold text-gray-900 mt-3">{{ $pendingEnrollments }}</p>
            <p class="text-sm text-gray-500 mt-2">Track enrollments that need attention.</p>
            <a href="{{ route('admin.enrollments.index') }}" class="inline-flex items-center gap-2 mt-4 text-sm font-medium text-orange-600 hover:text-orange-700">
                View enrollments <span aria-hidden="true">→</span>
            </a>
        </div>

        <div class="p-6 bg-white rounded-lg shadow-sm border border-gray-200">
            <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wide">User Queries</h3>
            <p class="text-3xl font-semibold text-gray-900 mt-3">{{ $openQueries }}</p>
            <p class="text-sm text-gray-500 mt-2">Respond to open questions quickly.</p>
            <a href="{{ route('admin.queries.index') }}" class="inline-flex items-center gap-2 mt-4 text-sm font-medium text-orange-600 hover:text-orange-700">
                Open inbox <span aria-hidden="true">→</span>
            </a>
        </div>
    </div>
</div>
@endsection