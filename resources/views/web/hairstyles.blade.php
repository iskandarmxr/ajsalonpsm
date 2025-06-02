<x-app-layout>
    <div class="bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-4 lg:px-8 py-10">
            <div class="flex items-baseline justify-between border-b border-gray-200 pb-6 pt-2">
                <h1 class="text-3xl font-bold tracking-tight text-pink-500">Hairstyles Collection</h1>
            </div>

                <!-- Categories -->
                @foreach($categories as $category)
                    <div class="mb-16 pt-4">
                        <h2 class="text-xl font-bold text-pink-500 mb-8">{{ $category->name }}</h2>
                        <div class="relative">
                            <div class="flex overflow-x-auto space-x-6 p-4 scrollbar-hide" id="slider-{{ $category->id }}">
                                @foreach($category->hairstyles as $hairstyle)
                                    <div class="flex-none w-80">
                                        <div class="bg-white rounded-lg shadow-lg overflow-hidden transition-transform hover:scale-105">
                                            <img src="{{ Storage::url($hairstyle->image) }}" 
                                                 alt="{{ $hairstyle->name }}" 
                                                 class="w-full h-64 object-cover">
                                            <div class="p-6">
                                                <h3 class="text-xl font-semibold text-gray-800 mb-2">{{ $hairstyle->name }}</h3>
                                                <p class="text-gray-600">{{ $hairstyle->description }}</p>
                                                <a href="{{ route('services') }}" 
                                                   class="mt-4 inline-block bg-pink-500 text-white px-6 py-2 rounded-full hover:bg-pink-600 transition-colors">
                                                    Book Now
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    <x-footer />

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            @foreach($categories as $category)
                setInterval(() => {
                    const slider = document.getElementById('slider-{{ $category->id }}');
                    if (slider.scrollLeft + slider.clientWidth >= slider.scrollWidth) {
                        slider.scrollLeft = 0;
                    } else {
                        slider.scrollLeft += slider.clientWidth;
                    }
                }, 3000);
            @endforeach
        });
    </script>
</x-app-layout>