@extends('layouts.app')

@section('content')

<section class="py-20 bg-white">
    <div class="max-w-5xl mx-auto px-6">

        <a href="{{ route('eca.index') }}" 
           class="text-orange-600 hover:underline">&larr; Back to ECAs</a>

        <div class="mt-6 bg-white rounded-2xl shadow-lg border overflow-hidden">

            {{-- Thumbnail --}}
            <img src="{{ $eca->thumbnail ?? '/default-eca.png' }}" 
                 class="w-full h-80 object-cover">

            <div class="p-8">

                {{-- Title --}}
                <h1 class="text-4xl font-bold text-gray-900">
                    {{ $eca->title }}
                </h1>

                {{-- Category --}}
                <p class="text-orange-600 mt-2 font-medium">
                    {{ ucfirst($eca->category) }}
                </p>

                {{-- Description --}}
                <p class="mt-6 text-gray-700 leading-relaxed">
                    {{ $eca->full_description }}
                </p>

                {{-- Instructor --}}
                <div class="mt-6 p-4 bg-orange-50 rounded-xl">
                    <p class="font-semibold text-gray-800">Instructor</p>
                    <p class="text-gray-700">
                        {{ $eca->instructor ?? 'Not Provided' }}
                    </p>
                </div>

                {{-- Enrollment Action --}}
                <div class="mt-8">

                    @guest
                        {{-- Not logged in --}}
                        <a href="{{ route('login') }}"
                           class="inline-block px-6 py-3 bg-orange-600 text-white rounded-xl hover:bg-orange-700 transition">
                            Login to Request Enrollment
                        </a>

                    @else
                        {{-- Logged in --}}
                        @if(!$enrollment)
                            {{-- No enrollment yet --}}
                            <form method="POST" action="{{ route('eca.join', $eca->id) }}">
                                @csrf
                                <button
                                    class="px-6 py-3 bg-orange-600 text-white rounded-xl hover:bg-orange-700 transition">
                                    Request Enrollment
                                </button>
                            </form>

                        @elseif($enrollment->status === 'pending')
                            {{-- Pending --}}
                            <button
                                class="px-6 py-3 bg-yellow-400 text-white rounded-xl cursor-not-allowed"
                                disabled>
                                Pending Admin Approval
                            </button>

                        @elseif($enrollment->status === 'approved')
                            {{-- Approved --}}
                            <button
                                class="px-6 py-3 bg-green-600 text-white rounded-xl cursor-not-allowed"
                                disabled>
                                Enrolled
                            </button>
                        @endif
                    @endguest

                </div>

            </div>
        </div>

    </div>
</section>

@endsection
