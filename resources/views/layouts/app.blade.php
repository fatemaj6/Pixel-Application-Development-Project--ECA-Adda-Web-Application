<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ECA Adda</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-white text-gray-900">

    {{-- Navbar --}}
    @include('components.navbar')

    <main>
        @yield('content')
    </main>

    @if(session('status'))
    <div class="max-w-7xl mx-auto px-6 mt-6">
        <div class="bg-green-50 border border-green-200 text-green-800 p-3 rounded">
            {{ session('status') }}
        </div>
    </div>
@endif

@if($errors->any())
    <div class="max-w-7xl mx-auto px-6 mt-6">
        <div class="bg-red-50 border border-red-200 text-red-800 p-3 rounded">
            <ul class="list-disc pl-5">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    </div>
@endif

    {{-- Footer --}}
    @include('components.footer')

</body>
</html>
