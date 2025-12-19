@extends('layouts.dashboard')

@section('content')
<div class="max-w-5xl mx-auto px-6 py-10">
    <div class="flex flex-col gap-4 mb-6">
        <h2 class="text-3xl font-semibold text-orange-600">Book Your 1-to-1 Session</h2>
        <p class="text-gray-700">
            Lock in a 30-minute slot with our team for personalized guidance. Pick the time that works
            best for you and you’ll get a calendar invite instantly.
        </p>
    </div>

    <div class="bg-white border border-gray-200 rounded-lg shadow-sm p-6">
        <div class="mb-4 flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-600">Powered by Calendly</p>
                <p class="text-sm text-gray-500">Times automatically adjust to your timezone.</p>
            </div>
            <a href="{{ route('dashboard.index') }}"
               class="px-3 py-2 bg-gray-100 text-gray-800 text-sm font-medium rounded hover:bg-gray-200 transition">
                Back to Dashboard
            </a>
        </div>

        <!-- Calendly inline widget begin -->
        <div class="calendly-inline-widget"
             data-url="https://calendly.com/taqia-graduate/30min?hide_event_type_details=1&text_color=ca5b27"
             style="min-width:320px;height:700px;"></div>
        <!-- Calendly inline widget end -->
    </div>
</div>
@endsection

@push('scripts')
<script type="text/javascript" src="https://assets.calendly.com/assets/external/widget.js" async></script>
@endpush
