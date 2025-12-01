@extends('layouts.app')

@section('content')

<section class="py-20 bg-white">
    <div class="max-w-5xl mx-auto px-6">

        <a href="{{ route('eca.index') }}" 
           class="text-orange-600 hover:underline">&larr; Back to ECAs</a>

        <div class="mt-6 bg-white rounded-2xl shadow-lg border overflow-hidden">

            <img src="{{ $eca->thumbnail ?? '/default-eca.png' }}" 
                 class="w-full h-80 object-cover">

            <div class="p-8">

                <h1 class="text-4xl font-bold text-gray-900">{{ $eca->title }}</h1>

                <p class="text-orange-600 mt-2 font-medium">
                    {{ ucfirst($eca->category) }}
                </p>

                <p class="mt-6 text-gray-700 leading-relaxed">
                    {{ $eca->full_description }}
                </p>

                <div class="mt-6 p-4 bg-orange-50 rounded-xl">
                    <p class="font-semibold text-gray-800">Instructor:</p>
                    <p class="text-gray-700">{{ $eca->instructor ?? 'Not Provided' }}</p>
                </div>

                <div class="mt-6">
                    @if($joined)
                        <button class="px-6 py-3 bg-gray-400 text-white rounded-xl cursor-not-allowed">
                            Already Joined
                        </button>
                    @else
                        <form method="POST" action="{{ route('eca.join', $eca->id) }}">
                            @csrf
                            <button class="px-6 py-3 bg-orange-600 text-white rounded-xl hover:bg-orange-700 transition">
                                Join This ECA
                            </button>
                        </form>
                    @endif
                </div>

            </div>
        </div>

    </div>
</section>

@endsection
