@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Add New ECA</h1>

    <form action="{{ route('eca.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        {{-- Title --}}
        <div class="mb-3">
            <label class="form-label">Title *</label>
            <input type="text" name="title" class="form-control" required>
        </div>

        {{-- Category --}}
        <div class="mb-3">
            <label class="form-label">Category *</label>
            <input type="text" name="category" class="form-control" required>
        </div>

        {{-- Level --}}
        <div class="mb-3">
            <label class="form-label">Level</label>
            <input type="text" name="level" class="form-control">
        </div>

        {{-- Instructor --}}
        <div class="mb-3">
            <label class="form-label">Instructor</label>
            <input type="text" name="instructor" class="form-control">
        </div>

        {{-- Short Description --}}
        <div class="mb-3">
            <label class="form-label">Short Description *</label>
            <textarea name="short_description" class="form-control" required></textarea>
        </div>

        {{-- Full Description --}}
        <div class="mb-3">
            <label class="form-label">Full Description *</label>
            <textarea name="full_description" class="form-control" rows="6" required></textarea>
        </div>

        {{-- Thumbnail --}}
        <div class="mb-3">
            <label class="form-label">Thumbnail (optional)</label>
            <input type="file" name="thumbnail" class="form-control">
        </div>

        <button type="submit" class="btn btn-success">Create ECA</button>
    </form>
</div>
@endsection
