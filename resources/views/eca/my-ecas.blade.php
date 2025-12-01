@extends('layouts.app')

@section('content')

<section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-6">

        <h1 class="text-4xl font-bold text-orange-600 mb-10">My ECAs</h1>

        @if($ecas->count() == 0)
            <p class="text-gray-600">You have not joined any ECA yet.</p>
        @endif

        <div class="grid md:grid-cols-3 gap-10">

            @foreach ($ecas as $eca)

            <div class="bg-white rounded-xl shadow-lg overflow-hidden border">

                <img src="{{ $eca->thumbnail ?? '/default-eca.png' }}"
                     class="w-full h-48 object-cover">

                <div class="p-6">
                    <h2 class="text-xl font-bold">{{ $eca->title }}</h2>
                    <p class="text-orange-600 text-sm mt-1">{{ ucfirst($eca->category) }}</p>

                    <p class="text-gray-600 text-sm mt-3">
                        {{ Str::limit($eca->short_description, 80) }}
                    </p>

                    <a href="{{ route('eca.show', $eca->id) }}"
                       class="inline-block mt-5 text-orange-600 hover:underline">
                       View Details
                    </a>
                </div>

            </div>

            @endforeach

        </div>

    </div>
</section>

@endsection
