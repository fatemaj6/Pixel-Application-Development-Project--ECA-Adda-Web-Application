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

    {{-- Footer --}}
    @include('components.footer')

</body>
</html>
