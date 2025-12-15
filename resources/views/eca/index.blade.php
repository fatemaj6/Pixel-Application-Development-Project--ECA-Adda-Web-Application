@extends('layouts.app')

@section('content')

<section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-6">

        <h1 class="text-4xl font-bold text-orange-600 mb-6">Explore ECAs</h1>
        @auth
<div class="mt-12 flex justify-start">
    <a href="{{ route('dashboard.index') }}"
       class="px-4 py-2 bg-gray-200 text-gray-800 text-sm font-medium rounded
              hover:bg-gray-300 transition">
        ← Back to Dashboard
    </a>
</div>
<div class="mb-6 flex justify-end">
    <a href="{{ route('eca.my') }}"
       class="px-4 py-2 bg-orange-100 text-orange-600 font-medium rounded-lg
              hover:bg-orange-200 transition">
        My ECAs
    </a>
</div>
@endauth

        {{-- 🔍 Search & Sort --}}
        <form method="GET" action="{{ route('eca.index') }}" 
              class="mb-10 flex flex-col md:flex-row gap-4">

            {{-- Search --}}
            <input 
                type="text" 
                name="search" 
                value="{{ request('search') }}"
                placeholder="Search by title, category or instructor"
                class="w-full md:w-1/2 px-4 py-2 border rounded-lg 
                       focus:ring-orange-500 focus:border-orange-500"
            >

            {{-- Sort --}}
            <select 
                name="sort"
                class="w-full md:w-1/4 px-4 py-2 border rounded-lg 
                       focus:ring-orange-500 focus:border-orange-500"
            >
                <option value="">Sort by</option>
                <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Newest</option>
                <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Oldest</option>
                <option value="az" {{ request('sort') == 'az' ? 'selected' : '' }}>A–Z</option>
                <option value="level" {{ request('sort') == 'level' ? 'selected' : '' }}>Level</option>
            </select>

            <button 
                type="submit"
                class="px-6 py-2 bg-orange-500 text-white rounded-lg 
                       hover:bg-orange-600"
            >
                Apply
            </button>
        </form>

        {{-- No ECAs --}}
        @if($ecas->count() == 0)
            <p class="text-gray-600">No ECAs available right now.</p>
        @endif

        {{-- ECA Grid --}}
<div class="grid md:grid-cols-3 gap-10">

    @foreach ($ecas as $eca)

    <div class="bg-white rounded-xl shadow-lg overflow-hidden border 
                hover:shadow-xl transition flex flex-col">

        {{-- Thumbnail --}}
        <img src="{{ $eca->thumbnail ?? '/default-eca.png' }}" 
             class="w-full h-52 object-cover">

        {{-- Content --}}
        <div class="p-6 flex-1 flex flex-col">

            <h2 class="text-xl font-bold text-gray-900">
                {{ $eca->title }}
            </h2>

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

            {{-- Actions --}}
            <div class="mt-6 flex gap-3">

                {{-- View Details --}}
                <a href="{{ route('eca.show', $eca->id) }}"
                   class="flex-1 text-center px-4 py-2 border border-orange-500 
                          text-orange-600 rounded-lg font-medium 
                          hover:bg-orange-500 hover:text-white transition">
                    View Details
                </a>

                {{-- Enroll --}}
                @auth
                    <a href="{{ route('eca.show', $eca->id) }}"
                       class="flex-1 text-center px-4 py-2 bg-orange-500 text-white 
                              rounded-lg font-medium hover:bg-orange-600 transition">
                        Enroll
                    </a>
                @else
                    <a href="{{ route('login') }}"
                       class="flex-1 text-center px-4 py-2 bg-orange-500 text-white 
                              rounded-lg font-medium hover:bg-orange-600 transition">
                        Login
                    </a>
                @endauth

            </div>

        </div>
    </div>

    @endforeach
</div>
    </div>
</section>

@endsection
