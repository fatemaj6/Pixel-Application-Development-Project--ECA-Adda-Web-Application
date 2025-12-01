@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto py-8">
    <h2 class="text-xl font-bold mb-4">User Queries</h2>

    <div class="bg-white rounded shadow">
        <table class="w-full">
            <thead><tr class="border-b"><th class="p-3">From</th><th class="p-3">Email</th><th class="p-3">Message</th><th class="p-3">Status</th><th class="p-3">Action</th></tr></thead>
            <tbody>
                @foreach($queries as $q)
                <tr class="border-b">
                    <td class="p-3">{{ $q->name ?? ($q->user->name ?? 'User') }}</td>
                    <td class="p-3">{{ $q->email }}</td>
                    <td class="p-3">{{ Str::limit($q->message, 80) }}</td>
                    <td class="p-3">{{ $q->status }}</td>
                    <td class="p-3">
                        <a href="{{ route('admin.queries.show', $q) }}" class="px-3 py-1 border rounded text-sm">Open</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="p-3">{{ $queries->links() }}</div>
    </div>
</div>
@endsection
