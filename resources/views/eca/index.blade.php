@extends('layouts.app')

@section('content')

<section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-6">

        <h1 class="text-4xl font-bold text-orange-600 mb-10">Explore ECAs</h1>

        @if($ecas->count() == 0)
            <p class="text-gray-600">No ECAs available right now.</p>
        @endif

        <div class="grid md:grid-cols-3 gap-10">

            @foreach ($ecas as $eca)

            <a href="{{ route('eca.show', $eca->id) }}" 
               class="bg-white rounded-xl shadow-lg overflow-hidden border hover:shadow-xl transition">

                <img src="{{ $eca->thumbnail ?? '/default-eca.png' }}" 
                     class="w-full h-52 object-cover">

                <div class="p-6">
                    <h2 class="text-xl font-bold text-gray-900">{{ $eca->title }}</h2>

                    <p class="text-sm text-orange-600 font-medium mt-1">
                        {{ ucfirst($eca->category) ?? 'General' }}
                    </p>

                    <p class="text-gray-600 text-sm mt-3">
                        {{ Str::limit($eca->short_description, 80) }}
                    </p>

                    <div class="mt-4">
                        <span class="px-3 py-1 bg-orange-100 text-orange-600 rounded-full text-sm">
                            {{ $eca->level ?? 'Beginner' }}
                        </span>
                    </div>
                </div>

            </a>

            @endforeach

        </div>
    </div>
</section>

@endsection