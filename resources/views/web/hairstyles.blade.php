<x-app-layout>
    <div class="bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="text-center">
                <h1 class="text-4xl font-bold text-gray-900 mb-8">Hairstyle Collections</h1>
                <br>
                <!-- Search Bar -->
                <div class="max-w-xl mx-auto mb-12">
                    <div class="relative">
                        <input type="text" 
                               placeholder="Search Hairstyles..." 
                               class="w-full rounded-full border-gray-300 pl-10 pr-4 py-2 focus:border-pink-500 focus:ring-pink-500">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center">
                            <svg class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Categories -->
                @foreach($categories as $category)
                    <div class="mb-16">
                        <h2 class="text-3xl font-bold text-pink-500 mb-8">{{ $category->name }}</h2>
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