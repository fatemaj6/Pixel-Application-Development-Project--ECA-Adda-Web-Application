<nav class="w-full shadow-sm bg-white fixed top-0 left-0 z-50">
    <div class="max-w-7xl mx-auto flex items-center justify-between py-4 px-6">
        <div class="flex items-center gap-3">
            <img src="/landing/images/logo.png" class="w-9" alt="ECA Adda logo">
            <div>
                <p class="text-xs uppercase tracking-[0.2em] text-gray-400">Admin Panel</p>
                <p class="text-lg font-semibold text-orange-600">ECA Adda</p>
            </div>
        </div>

        <div class="hidden md:flex items-center gap-6 text-sm font-medium text-gray-600">
            <a href="{{ route('admin.dashboard') }}" class="hover:text-orange-500 transition">Dashboard</a>
            <a href="{{ route('admin.registrations.index') }}" class="hover:text-orange-500 transition">Registrations</a>
            <a href="{{ route('admin.ecas.index') }}" class="hover:text-orange-500 transition">ECAs</a>
            <a href="{{ route('admin.enrollments.index') }}" class="hover:text-orange-500 transition">Enrollments</a>
            <a href="{{ route('admin.queries.index') }}" class="hover:text-orange-500 transition">Queries</a>
        </div>

        <div class="flex items-center gap-4">
            <span class="hidden sm:inline text-sm text-gray-600">
                {{ optional(Auth::guard('admin')->user())->name ?? 'Admin' }}
            </span>

            @if (Route::has('admin.logout'))
                <form action="{{ route('admin.logout') }}" method="POST">
                    @csrf
                    <button class="px-4 py-2 bg-gray-900 text-white text-sm font-medium rounded-md hover:bg-gray-800 transition">
                        Logout
                    </button>
                </form>
            @elseif (Route::has('logout'))
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button class="px-4 py-2 bg-gray-900 text-white text-sm font-medium rounded-md hover:bg-gray-800 transition">
                        Logout
                    </button>
                </form>
            @endif
        </div>
    </div>
</nav>

<div class="pt-20"></div>