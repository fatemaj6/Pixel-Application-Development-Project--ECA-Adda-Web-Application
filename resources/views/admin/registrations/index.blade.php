@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto py-8">
    <h2 class="text-xl font-bold mb-4">Pending Registrations</h2>

    @if(session('success')) <div class="mb-4 text-green-600">{{ session('success') }}</div> @endif

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        @foreach($users as $user)
            <div class="bg-white p-4 rounded shadow">
                <h3 class="font-semibold">{{ $user->name }} <span class="text-sm text-gray-500">({{ $user->email }})</span></h3>
                <p class="text-sm text-gray-600 mt-1">Package: {{ $user->package_type ?? 'tier2' }}</p>
                <p class="text-sm text-gray-600">Registered: {{ $user->created_at->format('d M, Y H:i') }}</p>

                <div class="mt-3 flex gap-2">
                    <a href="{{ route('admin.registrations.show', $user) }}" class="px-3 py-1 border rounded text-sm">Open</a>

                    <form action="{{ route('admin.registrations.approve', $user) }}" method="POST" onsubmit="return confirm('Approve this registration?');">
                        @csrf
                        <button class="px-3 py-1 bg-green-600 text-white rounded text-sm">Approve</button>
                    </form>
                </div>
            </div>
        @endforeach
    </div>

    <div class="mt-6">
        {{ $users->links() }}
    </div>
</div>
@endsection
