<section class="py-24 bg-white">
    <div class="max-w-7xl mx-auto px-6">

        <div class="grid md:grid-cols-4 gap-8">

            @foreach (['club1.jpg'=>'Foreign Language Club',
                       'club2.jpg'=>'Creative Writing Club',
                       'club3.jpg'=>'Painting Club',
                       'club4.jpg'=>'Rebellion Club'] as $img => $title)

            <div class="relative cursor-pointer overflow-hidden 
                        rounded-2xl shadow-lg group">

                <img src="/landing/images/clubs/{{ $img }}" 
                     class="w-full h-80 object-cover group-hover:scale-110 transition duration-500">

                <h3 class="absolute bottom-4 left-4 text-white text-xl font-bold">
                    {{ $title }}
                </h3>

            </div>

            @endforeach

        </div>

    </div>
</section>
