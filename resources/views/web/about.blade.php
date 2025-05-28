<x-app-layout>
    <x-slot name="mainLogoRoute">
        {{ route('home') }}
    </x-slot>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('About Us') }}
        </h2>
    </x-slot>

    <!-- Our Story Section -->
    <section class="py-20">
        <div class="container gap-10 pb-5 mx-auto px-4">
            <div class="grid md:grid-cols-2 gap-x-24 gap-y-32 items-center">
                <div class="order-2 md:order-1 space-y-12">
                    <h2 class="text-3xl font-bold text-pink-500 mb-6">Our Story</h2>
                    <p class="text-gray-600 mb-8">
                        Founded with a passion for beauty and a commitment to excellence, AJ Hair Salon has been transforming looks and boosting confidence since our establishment. Our journey began with a simple vision: to create a space where every client feels welcomed, understood, and beautiful.
                    </p>
                    <p class="text-gray-600 mb-8">
                        Today, we continue to uphold these values while embracing the latest trends and techniques in the beauty industry. Our team of skilled professionals is dedicated to providing you with the highest quality service and a truly personalized experience.
                    </p>
                </div>
                <div class="order-1 md:order-2">
                    <img src="{{ asset('images/salon1.png') }}" alt="AJ Hair Salon Story" class="shadow-lg w-full">
                </div>
            </div>
        </div>
    </section>

    <!-- Our Values Section -->
    <section class="pt-5 py-20 bg-white">
        <div class="container pb-5 mx-auto px-4">
            <h2 class="text-3xl font-bold text-center text-pink-500 m-2 mt-5">Our Values</h2>
            <div class="grid md:grid-cols-3 gap-8">
                <div class="text-center p-6">
                    <div class="text-4xl mb-4 text-pink-500">💫</div>
                    <h3 class="text-xl font-bold mb-4">Excellence</h3>
                    <p class="text-gray-600">We strive for excellence in every service we provide, ensuring you leave our salon feeling confident and beautiful.</p>
                </div>
                <div class="text-center p-6">
                    <div class="text-4xl mb-4 text-pink-500">🤝</div>
                    <h3 class="text-xl font-bold mb-4">Customer Focus</h3>
                    <p class="text-gray-600">Your satisfaction is our priority. We listen to your needs and deliver personalized solutions.</p>
                </div>
                <div class="text-center p-6">
                    <div class="text-4xl mb-4 text-pink-500">📚</div>
                    <h3 class="text-xl font-bold mb-4">Continuous Learning</h3>
                    <p class="text-gray-600">We stay updated with the latest trends and techniques to provide you with modern, innovative services.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Meet Our Team Section -->
    <section class="pt-5 pb-5 py-20">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl font-bold text-center text-gray-900 mb-12">Meet Our Expert Team</h2>
            <div class="grid md:grid-cols-3 gap-8">
                <!-- Team Member 1 -->
                <div class="card shadow-lg rounded-lg overflow-hidden">
                    <div class="relative">
                        <img src="{{ asset('images/team/stylist1.jpg') }}" alt="Team Member" class="w-full h-64 object-cover">
                        <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/60 to-transparent p-4">
                            <h3 class="text-xl font-bold text-white mb-1">Sarah Johnson</h3>
                            <p class="text-pink-300">Master Stylist</p>
                        </div>
                    </div>
                    <div class="p-6 bg-white">
                        <p class="text-gray-600">Specializing in color transformations and precision cuts with over 10 years of experience.</p>
                    </div>
                </div>

                <!-- Team Member 2 -->
                <div class="card shadow-lg rounded-lg overflow-hidden">
                    <div class="relative">
                        <img src="{{ asset('images/team/stylist2.jpg') }}" alt="Team Member" class="w-full h-64 object-cover">
                        <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/60 to-transparent p-4">
                            <h3 class="text-xl font-bold text-white mb-1">Michael Chen</h3>
                            <p class="text-pink-300">Creative Director</p>
                        </div>
                    </div>
                    <div class="p-6 bg-white">
                        <p class="text-gray-600">Award-winning stylist known for innovative styling and trending techniques.</p>
                    </div>
                </div>

                <!-- Team Member 3 -->
                <div class="card shadow-lg rounded-lg overflow-hidden">
                    <div class="relative">
                        <img src="{{ asset('images/team/stylist3.jpg') }}" alt="Team Member" class="w-full h-64 object-cover">
                        <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/60 to-transparent p-4">
                            <h3 class="text-xl font-bold text-white mb-1">Emily Rodriguez</h3>
                            <p class="text-pink-300">Color Specialist</p>
                        </div>
                    </div>
                    <div class="p-6 bg-white">
                        <p class="text-gray-600">Expert in creating stunning, personalized color experiences for our clients.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Call to Action Section -->
    <section class="py-20 pt-3 pb-3 bg-pink-500 text-white">
        <div class="container mx-auto px-4 text-center">
            <h2 class="text-3xl font-bold mb-6">Experience the AJ Hair Salon Difference</h2>
            <p class="text-xl mb-8">Book your appointment today and let us help you achieve your perfect look</p>
            <a href="{{ route('services') }}" class="inline-block bg-white text-pink-500 px-8 py-4 rounded-full text-lg font-semibold hover:bg-pink-50 transition duration-300">Book Your Appointment</a>
        </div>
    </section>

    <!-- Footer container -->
    <x-footer />
</x-app-layout>