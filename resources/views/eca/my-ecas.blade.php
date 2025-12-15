@extends('layouts.app')

@section('content')
<section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-6">

        <a href="{{ route('eca.index') }}" 
           class="text-orange-600 hover:underline">&larr; Back to ECAs</a>

        <h1 class="text-4xl font-bold text-orange-600 mb-10">My ECAs</h1>

        @if($enrollments->count() == 0)
            <p class="text-gray-600">You have not joined any ECA yet.</p>
        @else
            <div class="grid md:grid-cols-3 gap-10">

                @foreach ($enrollments as $enrollment)
                <div class="bg-white rounded-xl shadow-lg overflow-hidden border">

                    <img src="{{ $enrollment->eca->thumbnail ?? '/default-eca.png' }}"
                         class="w-full h-48 object-cover">

                    <div class="p-6">
                        <h2 class="text-xl font-bold">
                            {{ $enrollment->eca->title }}
                        </h2>

                        <p class="text-orange-600 text-sm mt-1">
                            {{ ucfirst($enrollment->eca->category) }}
                        </p>

                        <p class="text-gray-600 text-sm mt-3">
                            {{ Str::limit($enrollment->eca->short_description, 80) }}
                        </p>

                        {{-- Status Badge --}}
                        <div class="mt-4">
                            @if($enrollment->status === 'pending')
                                <span class="px-3 py-1 bg-yellow-100 text-yellow-700 rounded-full text-sm">
                                    Pending Approval
                                </span>
                            @else
                                <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-sm">
                                    Confirmed
                                </span>
                            @endif
                        </div>

                        <a href="{{ route('eca.show', $enrollment->eca->id) }}"
                           class="inline-block mt-5 text-orange-600 hover:underline">
                           View Details
                        </a>
                    </div>

                </div>
                @endforeach

            </div>
        @endif

    </div>
</section>
@endsection
