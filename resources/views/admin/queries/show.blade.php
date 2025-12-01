@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto py-8">
    <h2 class="text-xl font-bold mb-4">Query from {{ $query->name }}</h2>

    <div class="bg-white p-6 rounded shadow">
        <p class="mb-4"><strong>Message:</strong><br>{{ $query->message }}</p>

        <form action="{{ route('admin.queries.reply', $query) }}" method="POST">
            @csrf
            <textarea name="reply" class="w-full border p-2 rounded mb-3" placeholder="Write a reply..." required></textarea>
            <button class="px-3 py-2 bg-orange-500 text-white rounded">Send Reply</button>
        </form>
    </div>
</div>
@endsection
