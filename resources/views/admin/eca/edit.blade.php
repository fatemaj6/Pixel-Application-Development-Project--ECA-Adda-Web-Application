@extends('layouts.admin')

@section('content')
<section class="py-10 bg-gray-50">
    <div class="max-w-3xl mx-auto px-6">

        <h1 class="text-3xl font-bold text-gray-900 mb-8">Edit ECA</h1>

        {{-- Flash Message --}}
        @if(session('success'))
            <div class="mb-6 p-4 bg-green-50 border border-green-200 text-green-800 rounded">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('admin.ecas.update', $eca->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6 bg-white p-6 rounded-xl shadow border">
            @csrf
            @method('PUT')

            {{-- Title --}}
            <div>
                <label class="block text-gray-700 font-medium mb-2">Title *</label>
                <input type="text" name="title" value="{{ $eca->title }}" required
                       class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-orange-400 focus:outline-none">
            </div>

            {{-- Category --}}
            <div>
                <label class="block text-gray-700 font-medium mb-2">Category *</label>
                <input type="text" name="category" value="{{ $eca->category }}" required
                       class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-orange-400 focus:outline-none">
            </div>

            {{-- Level --}}
            <div>
                <label class="block text-gray-700 font-medium mb-2">Level</label>
                <input type="text" name="level" value="{{ $eca->level }}"
                       class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-orange-400 focus:outline-none">
            </div>

            {{-- Instructor --}}
            <div>
                <label class="block text-gray-700 font-medium mb-2">Instructor</label>
                <input type="text" name="instructor" value="{{ $eca->instructor }}"
                       class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-orange-400 focus:outline-none">
            </div>

            {{-- Short Description --}}
            <div>
                <label class="block text-gray-700 font-medium mb-2">Short Description *</label>
                <textarea name="short_description" required
                          class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-orange-400 focus:outline-none">{{ $eca->short_description }}</textarea>
            </div>

            {{-- Full Description --}}
            <div>
                <label class="block text-gray-700 font-medium mb-2">Full Description *</label>
                <textarea name="full_description" rows="6" required
                          class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-orange-400 focus:outline-none">{{ $eca->full_description }}</textarea>
            </div>

            {{-- Existing Thumbnail --}}
            @if($eca->thumbnail)
                <div>
                    <label class="block text-gray-700 font-medium mb-2">Current Thumbnail</label>
                    <img src="{{ $eca->thumbnail }}" class="w-32 rounded-lg border">
                </div>
            @endif

            {{-- Upload New Thumbnail --}}
            <div>
                <label class="block text-gray-700 font-medium mb-2">Replace Thumbnail</label>
                <input type="file" name="thumbnail"
                       class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-orange-400 focus:outline-none">
            </div>

            {{-- Submit Button --}}
            <div class="pt-4">
                <button type="submit"
                        class="w-full bg-orange-500 text-white px-6 py-3 rounded-lg font-semibold hover:bg-orange-600 transition">
                    Update ECA
                </button>
            </div>
        </form>
    </div>
</section>
@endsection
