<x-app-layout>
    <x-slot name="mainLogoRoute">
        {{ route('home') }}
    </x-slot>

    <!-- Hero Section -->
    <section class="relative bg-cover bg-center bg-no-repeat " style="background-image: url('{{ asset('images/happy-clients.jpg') }}');">
        <div class="absolute inset-0 bg-gradient-to-r from-white/95 to-white/0 ltr:bg-gradient-to-r rtl:bg-gradient-to-l sm:bg-transparent sm:from-white/95 sm:to-white/0"></div>
            <div class="relative mx-auto max-w-screen-xl px-4 py-32 sm:px-6 lg:flex lg:h-screen lg:items-center lg:px-8">
                <div class="max-w-xl text-left ltr:sm:text-left rtl:sm:text-right">
                    <h1 class="text-3xl font-extrabold sm:text-5xl text-neutral-700">
                    Join Our Loyalty Program & Get Rewarded for Every Appointments!
                    </h1>
                    <h2 class="text-2xl text-black mb-8">Earn Points, and Enjoy Exclusive Perks!</h2>
                    <p class="mt-4 max-w-lg sm:text-xl/relaxed">
                    10 point per one completed appointment, redeem for free services, and more!</p>
                    <div class="mt-8 flex flex-wrap gap-4 text-center">
                        <a href="{{route('services')}}" class="block w-full rounded bg-pink-500 px-12 py-3 text-lg font-medium text-white shadow hover:bg-pink-700 focus:outline-none focus:ring active:bg-pink-500 sm:w-auto"
                        >
                        Book Now
                        </a>
                    </div>
                </div>
            </div>
    </section>

<!-- Rewards Carousel Section -->
    <section class="py-12 md:py-20">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl font-bold text-center mb-4">Rewards & Loyalty Programs</h2>
            <p class="text-xl text-center mb-8">Complete more appointments to gain more points!</p>
            
            <!-- Carousel Container -->
            <div class="relative overflow-hidden">
                <!-- Carousel Track -->
                <div id="rewardsCarousel" class="flex gap-6 pb-8 transition-transform duration-500 ease-in-out">
                    @foreach($rewards as $reward)
                    <!-- Reward Card - Mobile width (80vw) / Desktop width (auto) -->
                    <div class="flex-shrink-0 w-[80vw] md:w-auto">
                        <div class="bg-white rounded-xl shadow-lg overflow-hidden transition-all duration-300 hover:shadow-xl h-full mx-2">
                            @if($reward->image_path)
                            <div class="h-40 bg-gray-100 overflow-hidden">
                                <img src="{{ Storage::url($reward->image_path) }}" 
                                    alt="{{ $reward->name }}" 
                                    class="w-full h-full object-cover">
                            </div>
                            @endif
                            <div class="p-6">
                                <div class="flex items-center justify-between mb-3">
                                    <h3 class="text-xl font-bold text-gray-800">{{ $reward->name }}</h3>
                                    @if($reward->points_required)
                                    <span class="bg-blue-100 text-blue-800 text-sm font-semibold px-3 py-1 rounded-full">
                                        {{ $reward->points_required }} pts
                                    </span>
                                    @endif
                                </div>
                                <p class="text-gray-600">{{ $reward->description }}</p>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                
                <!-- Navigation Arrows (Desktop only) -->
                <button class="hidden md:block absolute left-4 top-1/2 -translate-y-1/2 bg-white/80 hover:bg-white p-2 rounded-full shadow-md z-10" onclick="prevReward()">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                </button>
                <button class="hidden md:block absolute right-4 top-1/2 -translate-y-1/2 bg-white/80 hover:bg-white p-2 rounded-full shadow-md z-10" onclick="nextReward()">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </button>
            </div>
        </div>
    </section>

    <!-- How It Works -->
    <section class="bg-white py-10 bg-gray-100">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl font-bold text-center mb-12">How It Works</h2>

            <div class="min-w-full">
                        <div class="grid md:grid-cols-3 gap-8 px-4">
                            <div class="text-center bg-pink-500 rounded-lg p-6">
                                <i class="fas fa-book-open text-4xl mb-4 text-white"></i>
                                <h3 class="text-xl font-bold mb-2 text-white">Book Appointment</h3>
                                <p class="text-white">Select Your Desired Service</p>
                            </div>
                            <div class="text-center bg-pink-500 rounded-lg p-6">
                                <i class="fas fa-coins text-4xl mb-4 text-white"></i>
                                <h3 class="text-xl font-bold mb-2 text-white">Earn Points</h3>
                                <p class="text-white">For Every Successful Appointment</p>
                            </div>
                            <div class="text-center bg-pink-500 rounded-lg p-6">
                                <i class="fas fa-gift text-4xl mb-4 text-white"></i>
                                <h3 class="text-xl font-bold mb-2 text-white">Redeem Rewards</h3>
                                <p class="text-white">Free Service Upon Redemption</p>
                            </div>
                        </div>
                    </div>
        </div>
    </section>

    <!-- FAQ Section - Accordion Style -->
    <section class="py-20 bg-gray-100">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl font-bold text-center mb-12">Frequently Asked Questions (FAQ)</h2>
            <div class="max-w-3xl mx-auto space-y-4">
                <!-- FAQ Item 1 -->
                <div class="border border-gray-200 rounded-lg overflow-hidden">
                    <button 
                        class="accordion-btn w-full flex justify-between items-center p-6 text-left bg-white hover:bg-gray-50 transition"
                        onclick="toggleAccordion(this)"
                    >
                        <h3 class="text-xl font-bold">Is there a fee to register?</h3>
                        <svg class="w-6 h-6 transform transition-transform duration-200" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div class="accordion-content hidden p-6 bg-gray-50">
                        <p>No, it’s completely free! Register now or Log in if you already have signed in.</p>
                    </div>
                </div>

                <!-- FAQ Item 2 -->
                <div class="border border-gray-200 rounded-lg overflow-hidden">
                    <button 
                        class="accordion-btn w-full flex justify-between items-center p-6 text-left bg-white hover:bg-gray-50 transition"
                        onclick="toggleAccordion(this)"
                    >
                        <h3 class="text-xl font-bold">Do my points expire?</h3>
                        <svg class="w-6 h-6 transform transition-transform duration-200" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div class="accordion-content hidden p-6 bg-gray-50">
                        <p>You will receive points per completed appointments and has expiration date of 6 months from the completed appointmentd date.</p>
                    </div>
                </div>

                <!-- FAQ Item 3 -->
                <div class="border border-gray-200 rounded-lg overflow-hidden">
                    <button 
                        class="accordion-btn w-full flex justify-between items-center p-6 text-left bg-white hover:bg-gray-50 transition"
                        onclick="toggleAccordion(this)"
                    >
                        <h3 class="text-xl font-bold">Can I combine my rewards?</h3>
                        <svg class="w-6 h-6 transform transition-transform duration-200" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div class="accordion-content hidden p-6 bg-gray-50">
                        <p>You can redeem multiple rewards if your points balance is sufficient.</p>
                    </div>
                </div>
                <!-- FAQ Item 4 -->
                <div class="border border-gray-200 rounded-lg overflow-hidden">
                    <button 
                        class="accordion-btn w-full flex justify-between items-center p-6 text-left bg-white hover:bg-gray-50 transition"
                        onclick="toggleAccordion(this)"
                    >
                        <h3 class="text-xl font-bold">How to activate my loyalty card?</h3>
                        <svg class="w-6 h-6 transform transition-transform duration-200" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div class="accordion-content hidden p-6 bg-gray-50">
                        <p>You can activate your loyalty card points after ONE(1) completed appointment for the first time It's that simple!</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- JavaScript for Accordion -->
    <script>
        function toggleAccordion(button) {
            const content = button.nextElementSibling;
            const icon = button.querySelector('svg');

            // Toggle content visibility
            content.classList.toggle('hidden');
            
            // Rotate icon
            icon.classList.toggle('rotate-180');
            
            // Optional: Close other open accordions
            document.querySelectorAll('.accordion-content').forEach(item => {
                if (item !== content && !item.classList.contains('hidden')) {
                    item.classList.add('hidden');
                    item.previousElementSibling.querySelector('svg').classList.remove('rotate-180');
                }
            });
        }
    </script>
    <script>
        // Carousel Logic
        const carousel = document.getElementById('rewardsCarousel');
        const rewardCards = document.querySelectorAll('#rewardsCarousel > div');
        let currentIndex = 0;
        const cardWidth = window.innerWidth * 0.8 + 16; // 80vw + gap
        
        // Auto-scroll every 3 seconds
        let autoScroll = setInterval(nextReward, 3000);
        
        function updateCarousel() {
            carousel.style.transform = `translateX(-${currentIndex * cardWidth}px)`;
        }
        
        function nextReward() {
            currentIndex = (currentIndex + 1) % rewardCards.length;
            updateCarousel();
            resetAutoScroll();
        }
        
        function prevReward() {
            currentIndex = (currentIndex - 1 + rewardCards.length) % rewardCards.length;
            updateCarousel();
            resetAutoScroll();
        }
        
        function resetAutoScroll() {
            clearInterval(autoScroll);
            autoScroll = setInterval(nextReward, 3000);
        }
        
        // Pause on hover
        carousel.addEventListener('mouseenter', () => clearInterval(autoScroll));
        carousel.addEventListener('mouseleave', () => autoScroll = setInterval(nextReward, 3000));
        
        // Mobile touch support
        let touchStartX = 0;
        carousel.addEventListener('touchstart', (e) => {
            touchStartX = e.touches[0].clientX;
            clearInterval(autoScroll);
        });
        
        carousel.addEventListener('touchend', (e) => {
            const touchEndX = e.changedTouches[0].clientX;
            if (touchStartX - touchEndX > 50) nextReward();
            if (touchStartX - touchEndX < -50) prevReward();
            autoScroll = setInterval(nextReward, 3000);
        });
    </script>
    <!-- Footer container -->
    <x-footer />
</x-app-layout>