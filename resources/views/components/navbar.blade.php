<nav class="w-full shadow-sm bg-white fixed top-0 left-0 z-50">
    <div class="max-w-7xl mx-auto flex items-center justify-between py-4 px-6">

        <!-- Logo (always goes to landing page) -->
        <div class="flex items-center gap-2">
            <a href="{{ route('landing') }}">
                <img src="/landing/images/logo.png" class="w-8" alt="logo">
            </a>
            <span class="font-semibold text-lg text-orange-600">ECA Adda</span>
        </div>

        <!-- Navigation Buttons -->
        <div class="flex gap-4 items-center">

            {{-- ================= USER LOGGED IN ================= --}}
            @auth
                {{-- Show dashboard ONLY on landing page --}}
                @if(request()->routeIs('landing'))
                    <a href="{{ route('dashboard.index') }}"
                       class="px-5 py-2 border border-orange-500 text-orange-600 rounded-lg font-semibold
                              hover:bg-orange-500 hover:text-white transition">
                        Dashboard
                    </a>
                @endif

                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button
                        class="px-5 py-2 bg-orange-500 text-white rounded-lg font-semibold
                               hover:bg-orange-600 transition">
                        Logout
                    </button>
                </form>
            @endauth


            {{-- ================= ADMIN LOGGED IN ================= --}}
            @auth('admin')
                {{-- Show dashboard ONLY on landing page --}}
                @if(request()->routeIs('landing'))
                    <a href="{{ route('admin.dashboard') }}"
                       class="px-5 py-2 border border-gray-800 text-gray-800 rounded-lg font-semibold
                              hover:bg-gray-800 hover:text-white transition">
                        Admin Dashboard
                    </a>
                @endif

                <form action="{{ route('admin.logout') }}" method="POST">
                    @csrf
                    <button
                        class="px-5 py-2 bg-orange-500 text-white rounded-lg font-semibold
                               hover:bg-orange-600 transition">
                        Admin Logout
                    </button>
                </form>
            @endauth


            {{-- ================= NO ONE LOGGED IN ================= --}}
            @guest
                <a href="{{ route('register.step1') }}"
                   class="px-5 py-2 border-2 border-blue-600 text-blue-600 rounded-lg font-semibold
                          hover:bg-blue-600 hover:text-white transition">
                    Register
                </a>

                <a href="{{ route('login') }}"
                   class="px-5 py-2 bg-orange-500 text-white rounded-lg font-semibold
                          hover:bg-orange-600 transition">
                    Login
                </a>
            @endguest

        </div>
    </div>
</nav>

<div class="pt-20"></div>
