@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Edit ECA</h1>

    <form action="{{ route('eca.update', $eca->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        {{-- Title --}}
        <div class="mb-3">
            <label class="form-label">Title *</label>
            <input type="text" name="title" class="form-control" value="{{ $eca->title }}" required>
        </div>

        {{-- Category --}}
        <div class="mb-3">
            <label class="form-label">Category *</label>
            <input type="text" name="category" class="form-control" value="{{ $eca->category }}" required>
        </div>

        {{-- Level --}}
        <div class="mb-3">
            <label class="form-label">Level</label>
            <input type="text" name="level" class="form-control" value="{{ $eca->level }}">
        </div>

        {{-- Instructor --}}
        <div class="mb-3">
            <label class="form-label">Instructor</label>
            <input type="text" name="instructor" class="form-control" value="{{ $eca->instructor }}">
        </div>

        {{-- Short Description --}}
        <div class="mb-3">
            <label class="form-label">Short Description *</label>
            <textarea name="short_description" class="form-control" required>{{ $eca->short_description }}</textarea>
        </div>

        {{-- Full Description --}}
        <div class="mb-3">
            <label class="form-label">Full Description *</label>
            <textarea name="full_description" class="form-control" rows="6" required>{{ $eca->full_description }}</textarea>
        </div>

        {{-- Existing Thumbnail --}}
        @if($eca->thumbnail)
            <div class="mb-3">
                <label class="form-label">Current Thumbnail</label><br>
                <img src="{{ $eca->thumbnail }}" width="120">
            </div>
        @endif

        {{-- Upload New Thumbnail --}}
        <div class="mb-3">
            <label class="form-label">Replace Thumbnail</label>
            <input type="file" name="thumbnail" class="form-control">
        </div>

        <button type="submit" class="btn btn-primary">Update ECA</button>
    </form>
</div>
@endsection
