@extends(auth()->check() ? 'layouts.dashboard' : 'layouts.app')

@section('content')

<div class="max-w-6xl mx-auto px-6 py-8">
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between mb-6">
        <div>
            <p class="text-sm uppercase tracking-[0.3em] text-gray-400">Explore</p>
            <h1 class="text-2xl font-semibold text-gray-900">{{ $eca->title }}</h1>
            <p class="text-gray-600">Full program details and enrollment status.</p>
        </div>
        <div class="flex flex-wrap items-center gap-3">
            <a href="{{ route('eca.index') }}"
               class="inline-flex items-center px-4 py-2 bg-white border border-gray-200 text-gray-700 text-sm font-medium rounded-md shadow-sm hover:border-gray-300 transition">
                Back to ECAs
            </a>
            @auth
                <a href="{{ route('eca.my') }}"
                   class="inline-flex items-center px-4 py-2 bg-orange-500 text-white text-sm font-medium rounded-md hover:bg-orange-600 transition">
                    My ECAs
                </a>
                <a href="{{ route('dashboard.index') }}"
                   class="inline-flex items-center px-4 py-2 bg-white border border-gray-200 text-gray-700 text-sm font-medium rounded-md shadow-sm hover:border-gray-300 transition">
                    Back to Dashboard
                </a>
            @endauth
        </div>
    </div>

    <div class="bg-white border border-gray-200 rounded-lg shadow-sm overflow-hidden">
        <img src="{{ $eca->thumbnail ?? '/default-eca.png' }}"
             class="w-full h-72 object-cover"
             alt="{{ $eca->title }} thumbnail">

        <div class="p-6 md:p-8 grid gap-6 lg:grid-cols-3">
            <div class="lg:col-span-2">
                <div class="flex flex-wrap items-center gap-2 mb-4">
                    <span class="px-3 py-1 bg-orange-100 text-orange-600 rounded-full text-sm">
                        {{ ucfirst($eca->category ?? 'General') }}
                    </span>
                    <span class="px-3 py-1 bg-gray-100 text-gray-600 rounded-full text-sm">
                        {{ $eca->level ?? 'Beginner' }}
                    </span>
                </div>

                <p class="text-gray-700 leading-relaxed">
                    {{ $eca->full_description }}
                </p>
            </div>

            <div class="space-y-5 rounded-lg border border-gray-100 bg-gray-50 p-5">
                <div>
                    <p class="text-xs uppercase tracking-[0.2em] text-gray-400">Instructor</p>
                    <p class="mt-1 font-semibold text-gray-800">
                        {{ $eca->instructor ?? 'Not Provided' }}
                    </p>
                </div>

                <div>
                    <p class="text-xs uppercase tracking-[0.2em] text-gray-400">Enrollment</p>
                    <div class="mt-2">
                        @guest
                            <a href="{{ route('login') }}"
                               class="inline-flex w-full items-center justify-center px-4 py-2 bg-orange-500 text-white rounded-md text-sm font-medium hover:bg-orange-600 transition">
                                Login to Request Enrollment
                            </a>
                        @else
                            @if(!$enrollment)
                                <form method="POST" action="{{ route('eca.join', $eca->id) }}">
                                    @csrf
                                    <button
                                        class="w-full inline-flex items-center justify-center px-4 py-2 bg-orange-500 text-white rounded-md text-sm font-medium hover:bg-orange-600 transition">
                                        Request Enrollment
                                    </button>
                                </form>
                            @elseif($enrollment->status === 'pending')
                                <span
                                    class="inline-flex w-full items-center justify-center px-4 py-2 bg-yellow-100 text-yellow-700 rounded-md text-sm font-medium">
                                    Pending Admin Approval
                                </span>
                            @elseif($enrollment->status === 'enrolled')
                                <span
                                    class="inline-flex w-full items-center justify-center px-4 py-2 bg-green-100 text-green-700 rounded-md text-sm font-medium">
                                    Enrolled
                                </span>
                            @endif
                        @endguest
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
