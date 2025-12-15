@extends('layouts.admin')

@section('content')
<section class="py-10 bg-gray-50">
    <div class="max-w-7xl mx-auto px-6">

        {{-- Header --}}
        <div class="flex items-center justify-between mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Manage ECAs</h1>
            <a href="{{ route('admin.ecas.create') }}" 
               class="px-4 py-2 bg-orange-500 text-white rounded-lg font-semibold hover:bg-orange-600 transition">
                Add New ECA
            </a>
        </div>

        {{-- Flash Message --}}
        @if(session('success'))
            <div class="mb-6 p-4 bg-green-50 border border-green-200 text-green-800 rounded">
                {{ session('success') }}
            </div>
        @endif

        {{-- ECAs Grid --}}
        @if($ecas->count() == 0)
            <p class="text-gray-600">No ECAs available.</p>
        @else
            <div class="grid md:grid-cols-3 gap-8">

                @foreach ($ecas as $eca)
                <div class="bg-white rounded-xl shadow border overflow-hidden hover:shadow-lg transition flex flex-col">

                    {{-- Thumbnail --}}
                    <img src="{{ $eca->thumbnail ?? '/default-eca.png' }}" 
                         class="w-full h-52 object-cover">

                    {{-- Content --}}
                    <div class="p-5 flex-1 flex flex-col justify-between">

                        <div>
                            <h2 class="text-xl font-bold text-gray-900">{{ $eca->title }}</h2>

                            <p class="text-sm text-orange-600 font-medium mt-1">
                                {{ ucfirst($eca->category) ?? 'General' }}
                            </p>

                            <p class="text-gray-600 text-sm mt-2">
                                Level: <span class="font-semibold">{{ $eca->level ?? 'Beginner' }}</span>
                            </p>

                            <p class="text-gray-500 text-sm mt-1">
                                Instructor: {{ $eca->instructor }}
                            </p>
                        </div>

                        {{-- Actions --}}
                        <div class="mt-4 flex gap-2">
                            <a href="{{ route('admin.ecas.edit', $eca->id) }}" 
                               class="flex-1 text-center px-3 py-2 bg-yellow-400 text-white rounded-lg font-medium hover:bg-yellow-500 transition">
                                Edit
                            </a>

                            <form action="{{ route('admin.ecas.destroy', $eca->id) }}" method="POST" class="flex-1"
                                  onsubmit="return confirm('Are you sure you want to delete this ECA?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        class="w-full px-3 py-2 bg-red-500 text-white rounded-lg font-medium hover:bg-red-600 transition">
                                    Delete
                                </button>
                            </form>
                        </div>

                    </div>
                </div>
                @endforeach

            </div>
        @endif

    </div>
</section>
@endsection
