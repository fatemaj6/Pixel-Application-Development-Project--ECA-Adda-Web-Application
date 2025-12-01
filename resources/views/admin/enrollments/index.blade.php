@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto py-8">
    <h2 class="text-xl font-bold mb-4">ECA Enrollments</h2>

    @if(session('success')) <div class="mb-4 text-green-600">{{ session('success') }}</div> @endif

    <table class="w-full bg-white rounded shadow">
        <thead>
            <tr class="text-left border-b">
                <th class="p-3">Student</th>
                <th class="p-3">Email</th>
                <th class="p-3">ECA</th>
                <th class="p-3">Status</th>
                <th class="p-3">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($enrollments as $en)
            <tr class="border-b">
                <td class="p-3">{{ $en->user->name }}</td>
                <td class="p-3">{{ $en->user->email }}</td>
                <td class="p-3">{{ $en->eca->title }}</td>
                <td class="p-3">{{ $en->status }}</td>
                <td class="p-3">
                    @if($en->status !== 'done')
                    <form action="{{ route('admin.enrollments.done', $en) }}" method="POST" onsubmit="return confirm('Mark as done (moved to enrolled)?');">
                        @csrf
                        <button class="px-3 py-1 bg-green-600 text-white rounded text-sm">Done</button>
                    </form>
                    @else
                        <span class="text-sm text-gray-500">Completed</span>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="mt-4">{{ $enrollments->links() }}</div>
</div>
@endsection
