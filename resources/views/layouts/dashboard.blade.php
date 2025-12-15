<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ECA Adda Dashboard</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-gray-50 text-gray-900">

    {{-- Minimal Dashboard Navbar --}}
    <nav class="w-full bg-white shadow-sm fixed top-0 left-0 z-50">
        <div class="max-w-7xl mx-auto flex items-center justify-between py-4 px-6">
            <div class="flex items-center gap-2">
                <a href="{{ route('landing') }}"><img src="/landing/images/logo.png" class="w-8" alt="logo"></a>
                <span class="font-semibold text-lg text-orange-600">ECA Adda</span>
            </div>

            <div class="flex items-center gap-4">
                
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" 
                            class="px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600 transition">
                        Logout
                    </button>
                </form>
            </div>
        </div>
    </nav>

    {{-- Spacer for fixed navbar --}}
    <div class="pt-20"></div>

    {{-- Main Content --}}
    <main>
        @yield('content')
    </main>

    {{-- Flash Messages --}}
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

    @stack('scripts')
</body>
</html>
