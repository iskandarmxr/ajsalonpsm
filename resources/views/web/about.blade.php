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
    <footer
    class="bg-pink-500 text-center text-neutral-100 lg:text-left mt-1">
    <div
    class="flex items-center justify-center border-b-2 border-neutral-200 p-6 lg:justify-between">
    <div class="mr-12 hidden lg:block">
        <span>Get connected with us on social networks:</span>
    </div>
    <!-- Social network icons container -->
    <div class="flex justify-center">
        <a href="https://www.facebook.com/people/AJ-Hair-Saloon/100063676083353/" class="mr-6 text-neutral-600 dark:text-neutral-200">
        <svg
            xmlns="http://www.w3.org/2000/svg"
            class="h-4 w-4"
            fill="currentColor"
            viewBox="0 0 24 24">
            <path
            d="M9 8h-3v4h3v12h5v-12h3.642l.358-4h-4v-1.667c0-.955.192-1.333 1.115-1.333h2.885v-5h-3.808c-3.596 0-5.192 1.583-5.192 4.615v3.385z" />
        </svg>
        </a>
        <a href="#!" class="mr-6 text-neutral-600 dark:text-neutral-200">
        <svg
            xmlns="http://www.w3.org/2000/svg"
            class="h-4 w-4"
            fill="currentColor"
            viewBox="0 0 24 24">
            <path
            d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z" />
        </svg>
        </a>

        <a href="#!" class="mr-6 text-neutral-600 dark:text-neutral-200">
        <svg
            xmlns="http://www.w3.org/2000/svg"
            class="h-4 w-4"
            fill="currentColor"
            viewBox="0 0 24 24">
            <path
            d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z" />
        </svg>
        </a>


    </div>
    </div>

    <!-- Main container div: holds the entire content of the footer, including four sections (Tailwind Elements, Products, Useful links, and Contact), with responsive styling and appropriate padding/margins. -->
    <div class="mx-6 py-10 text-center md:text-left">
    <div class="grid-1 grid gap-8 md:grid-cols-2 lg:grid-cols-3">
        <!-- Tailwind Elements section -->
        <!-- Contact section -->

        <div>
        <h6
            class="mb-4 flex items-center justify-center font-semibold text-xl md:justify-start">
            <img class="w-10 h-10" src="{{ asset('images/logo-white.png')}}" alt="">
            AJ Hair Salon
        </h6>
        <p class="mb-4 flex items-center justify-center md:justify-start">
            <svg
            xmlns="http://www.w3.org/2000/svg"
            viewBox="0 0 24 24"
            fill="currentColor"
            class="mr-3 h-5 w-5">
            <path
                d="M11.47 3.84a.75.75 0 011.06 0l8.69 8.69a.75.75 0 101.06-1.06l-8.689-8.69a2.25 2.25 0 00-3.182 0l-8.69 8.69a.75.75 0 001.061 1.06l8.69-8.69z" />
            <path
                d="M12 5.432l8.159 8.159c.03.03.06.058.091.086v6.198c0 1.035-.84 1.875-1.875 1.875H15a.75.75 0 01-.75-.75v-4.5a.75.75 0 00-.75-.75h-3a.75.75 0 00-.75.75V21a.75.75 0 01-.75.75H5.625a1.875 1.875 0 01-1.875-1.875v-6.198a2.29 2.29 0 00.091-.086L12 5.43z" />
            </svg>
            P15,
            Lorong Permai 1,
            Taman Karak Permai,
            28600 Karak, Pahang
        </p>
        <p class="mb-4 flex items-center justify-center md:justify-start">
            <svg
            xmlns="http://www.w3.org/2000/svg"
            viewBox="0 0 24 24"
            fill="currentColor"
            class="mr-3 h-5 w-5">
            <path
                d="M1.5 8.67v8.58a3 3 0 003 3h15a3 3 0 003-3V8.67l-8.928 5.493a3 3 0 01-3.144 0L1.5 8.67z" />
            <path
                d="M22.5 6.908V6.75a3 3 0 00-3-3h-15a3 3 0 00-3 3v.158l9.714 5.978a1.5 1.5 0 001.572 0L22.5 6.908z" />
            </svg>
            info@ajhairsalon.com
        </p>
        <p class="mb-4 flex items-center justify-center md:justify-start">
            <svg
            xmlns="http://www.w3.org/2000/svg"
            viewBox="0 0 24 24"
            fill="currentColor"
            class="mr-3 h-5 w-5">
            <path
                fill-rule="evenodd"
                d="M1.5 4.5a3 3 0 013-3h1.372c.86 0 1.61.586 1.819 1.42l1.105 4.423a1.875 1.875 0 01-.694 1.955l-1.293.97c-.135.101-.164.249-.126.352a11.285 11.285 0 006.697 6.697c.103.038.25.009.352-.126l.97-1.293a1.875 1.875 0 011.955-.694l4.423 1.105c.834.209 1.42.959 1.42 1.82V19.5a3 3 0 01-3 3h-2.25C8.552 22.5 1.5 15.448 1.5 6.75V4.5z"
                clip-rule="evenodd" />
            </svg>
            012-638 8647
        </p>

        </div>

        <!-- Services section -->
        <div class="">
        <h6
            class="mb-4 flex justify-center font-semibold uppercase md:justify-start">
            Services
        </h6>
        <p class="mb-4">
            <a href="#!" class="text-neutral-600 dark:text-neutral-200"
            >Hair</a
            >
        </p>
        <p class="mb-4">
            <a href="#!" class="text-neutral-600 dark:text-neutral-200"
            >Nails</a
            >
        </p>
        <p class="mb-4">
            <a href="#!" class="text-neutral-600 dark:text-neutral-200"
            >Skin</a
            >
        </p>
        <p>
            <a href="#!" class="text-neutral-600 dark:text-neutral-200"
            >Makeup</a
            >
        </p>
        </div>
        <!-- Promotions section -->
        <div class="">
        <h6
            class="mb-4 flex justify-center font-semibold uppercase md:justify-start">
        Promotions
        </h6>
        <p class="mb-4">
            <a href="#!" class="text-neutral-600 dark:text-neutral-200"
            >Special Offers</a
            >
        </p>
        <p class="mb-4">
            <a href="#!" class="text-neutral-600 dark:text-neutral-200"
            >Loyalty Program</a
            >
        </p>
        <p class="mb-4">
            <a href="#!" class="text-neutral-600 dark:text-neutral-200"
            >Loyalty teirs</a
            >
        </p>

        </div>

    </div>
    </div>

    <!--Copyright section-->
    <div class="bg-white p-2 text-center">
    <span class="text-neutral-500">© 2025 Copyright:</span>
    <a
        class="font-semibold text-neutral-600"
        href="/"
        >AJ Hair Salon</a
    >
    </div>
    </footer>
</x-app-layout>