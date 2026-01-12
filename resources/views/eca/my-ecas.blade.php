@extends(auth()->check() ? 'layouts.dashboard' : 'layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-6 py-8">
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between mb-6">
        <div>
            <p class="text-sm uppercase tracking-[0.3em] text-gray-400">My ECAs</p>
            <h1 class="text-2xl font-semibold text-gray-900">My ECAs</h1>
            <p class="text-gray-600">Track your enrollment requests and confirmed programs.</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('eca.index') }}"
               class="inline-flex items-center px-4 py-2 bg-orange-500 text-white text-sm font-medium rounded-md hover:bg-orange-600 transition">
                Explore ECAs
            </a>
            <a href="{{ route('dashboard.index') }}"
               class="inline-flex items-center px-4 py-2 bg-white border border-gray-200 text-gray-700 text-sm font-medium rounded-md shadow-sm hover:border-gray-300 transition">
                Back to Dashboard
            </a>
        </div>
    </div>

    <div class="bg-white border border-gray-200 rounded-lg shadow-sm p-6">
        @if($enrollments->count() == 0)
            <p class="text-gray-600">You have not joined any ECA yet.</p>
            <a href="{{ route('eca.index') }}"
               class="inline-flex items-center mt-4 px-4 py-2 bg-orange-500 text-white text-sm font-medium rounded-md hover:bg-orange-600 transition">
                Browse ECAs
            </a>
        @else
            <div class="grid md:grid-cols-2 xl:grid-cols-3 gap-6">
                @foreach ($enrollments as $enrollment)
                    <div class="bg-white rounded-lg border border-gray-200 shadow-sm overflow-hidden flex flex-col">
                        <img src="{{ $enrollment->eca->thumbnail ?? '/default-eca.png' }}"
                             class="w-full h-40 object-cover"
                             alt="{{ $enrollment->eca->title }} thumbnail">

                        <div class="p-5 flex-1 flex flex-col">
                            <h2 class="text-lg font-semibold text-gray-900">
                                {{ $enrollment->eca->title }}
                            </h2>

                            <p class="text-sm text-orange-600 font-medium mt-1">
                                {{ ucfirst($enrollment->eca->category) }}
                            </p>

                            <p class="text-gray-600 text-sm mt-3">
                                {{ Str::limit($enrollment->eca->short_description, 80) }}
                            </p>

                            <div class="mt-4">
                                @if($enrollment->status === 'pending')
                                    <span class="px-3 py-1 bg-yellow-100 text-yellow-700 rounded-full text-sm">
                                        Pending Approval
                                    </span>
                                @else
                                    <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-sm">
                                        Confirmed
                                    </span>
                                @endif
                            </div>

                            <div class="mt-5">
                                <a href="{{ route('eca.show', $enrollment->eca->id) }}"
                                   class="inline-flex items-center text-orange-600 text-sm font-medium hover:text-orange-700">
                                    View Details
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>
@endsection
