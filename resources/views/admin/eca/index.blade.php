@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Manage ECAs</h1>

    <a href="{{ route('eca.create') }}" class="btn btn-primary mb-3">Add New ECA</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Thumbnail</th>
                <th>Title</th>
                <th>Category</th>
                <th>Level</th>
                <th>Instructor</th>
                <th>Actions</th>
            </tr>
        </thead>

        <tbody>
            @foreach($ecas as $eca)
            <tr>
                <td>
                    @if($eca->thumbnail)
                        <img src="{{ $eca->thumbnail }}" width="80">
                    @else
                        <span class="text-muted">None</span>
                    @endif
                </td>

                <td>{{ $eca->title }}</td>
                <td>{{ $eca->category }}</td>
                <td>{{ $eca->level }}</td>
                <td>{{ $eca->instructor }}</td>

                <td>
                    <a href="{{ route('eca.edit', $eca->id) }}" class="btn btn-sm btn-warning">Edit</a>

                    <form action="{{ route('eca.destroy', $eca->id) }}" method="POST" style="display:inline-block"
                          onsubmit="return confirm('Are you sure you want to delete this ECA?');">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm btn-danger">Delete</button>
                    </form>

                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
