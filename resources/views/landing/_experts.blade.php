<section class="py-24 bg-white">
    <div class="max-w-7xl mx-auto px-6">

        <h2 class="text-4xl font-extrabold mb-8">An opportunity to learn from the experts.</h2>

        <div class="grid grid-cols-5 gap-6">

            @foreach (['exp1.jpg','exp2.jpg','exp3.jpg','exp4.jpg','exp5.jpg'] as $exp)
                <img src="/landing/images/experts/{{ $exp }}" 
                     class="rounded-2xl shadow-lg hover:scale-110 transition duration-300">
            @endforeach

        </div>

    </div>
</section>
