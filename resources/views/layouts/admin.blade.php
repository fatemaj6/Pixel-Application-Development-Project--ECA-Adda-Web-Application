<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Panel</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100">

    {{-- Admin Navbar --}}
    <nav class="bg-white border-b shadow-sm px-6 py-4 flex justify-between items-center">
        <h1 class="text-lg font-bold text-orange-600">Admin Dashboard</h1>

        <form action="{{ route('admin.logout') }}" method="POST">
            @csrf
            <button class="px-4 py-2 bg-gray-800 text-white rounded hover:bg-gray-900">
                Logout
            </button>
        </form>
    </nav>

    {{-- Page Content --}}
    <main class="py-8">
        @yield('content')
    </main>

</body>
</html>
