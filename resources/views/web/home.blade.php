<x-app-layout>
  <x-slot name="mainLogoRoute">
    {{ route('home') }}
  </x-slot>


    <div class="relative">
        {{-- <img class="w-full" src="{{ asset('images\banner-salon.png') }}" alt="Banner image"> --}}
        {{-- <img class="max-h-fit w-full" src="{{ asset('images\salon1.png') }}" alt="Banner image"> --}}
        <!--
  Heads up! 👋

  This component comes with some `rtl` classes. Please remove them if they are not needed in your project.
-->

<section
class="relative bg-cover bg-center bg-no-repeat " style="background-image: url({{ asset('images/salon1.png') }}" ;>
<div class="absolute inset-0 bg-gradient-to-r from-white/95 to-white/0 ltr:bg-gradient-to-r rtl:bg-gradient-to-l sm:bg-transparent sm:from-white/95 sm:to-white/0"></div>

<div
  class="relative mx-auto max-w-screen-xl px-4 py-32 sm:px-6 lg:flex lg:h-screen lg:items-center lg:px-8"
>
  <div class="max-w-xl text-left ltr:sm:text-left rtl:sm:text-right">
    <h1 class="text-3xl font-extrabold sm:text-5xl text-neutral-700">
      Find Your Perfect Salon Experience at
      <strong class="block font-extrabold text-pink-500">
        AJ Hair Salon.      </strong>
    </h1>

    <p class="mt-4 max-w-lg sm:text-xl/relaxed">
      Discover a World of Beauty and Elegance. Elevate Your Style at AJ Hair Salon, Where Dreams Become Reality.
         </p>

    <div class="mt-8 flex flex-wrap gap-4 text-center">
      <a
        href="{{route('services')}}"
        class="block w-full rounded bg-pink-500 px-12 py-3 text-lg font-medium text-white shadow hover:bg-pink-700 focus:outline-none focus:ring active:bg-pink-500 sm:w-auto"
      >
Book Now      </a>


    </div>

  </div>
</div>
</section>

        {{-- <img class="w-full bg-cover" src="{{ asset('images\Salon2.jpg') }}" alt="Banner image"> --}}
        {{-- <div class="absolute right-1 top-5 font-black text-pink-600 text-7xl">30% OFF <br>THIS SEASON</div> --}}
 <div>
    <div class="text-center text-4xl font-semibold text-pink-500 m-2 mt-5">Categories</div>

    <div class="container flex gap-10 p-10 pt-3 justify-center mx-auto">
      <a href="#" class="text-center gap-2 duration-300 hover:scale-105">
          <img class="w-60 rounded-xl" src="{{ asset('images/hair.jpg')}}" alt="">
          <span class="text-pink-500 text-2xl">Hair</span>
      </a>
      <a href="#" class="text-center gap-2 duration-300 hover:scale-105">
        <img class="w-60 rounded-xl" src="{{ asset('images/nails.jpg')}}"  alt="">
        <span class="text-pink-500 text-2xl">Nails</span>

      </a>
      <a href="#" class="text-center gap-2 duration-300 hover:scale-105">
        <img class="w-60 rounded-xl" src="{{ asset('images/skin.jpg')}}" alt="">
        <span class="text-pink-500 text-2xl">Skin</span>

      </a>
      <a href="#" class="text-center gap-2 duration-300 hover:scale-105">
        <img class="w-60 rounded-xl" src="{{ asset('images/makeup.jpg')}}" alt="">
        <span class="text-pink-500 text-2xl">Makeup</span>
      </a>
    </div>

    </div>

    <section class="pt-5 bg-white">
      <div class="md:w-4/5 mx-auto">
        <div class="mx-auto text-center md:max-w-xl lg:max-w-3xl">
          <h3 class="mb-6 text-3xl text-pink-500 font-bold">Popular Services</h3>
          <p class="mb-6 pb-2 text-gray-700 md:mb-12 md:pb-0">
            Services Popular among our customers.
          </p>
        </div>

        <div class="flex flex-col md:flex-row mt-3 pb-7 h-max">
            @if($popularServices->count() > 0)
                @foreach ($popularServices as $service)
                    <x-service-card :service="$service"/>
                @endforeach
            @else
                <p class="mx-auto text-center block text-gray-700 md:mb-12 md:pb-0">
                    No Services Found
                </p>
            @endif
        </div>
      </div>

      <div class="flex justify-end mx-auto pb-5 gap-3 md:w-3/4">

        <a href="{{route('services')}}" class="bg-pink-500 hover:bg-pink-600 text-white font-bold py-2 px-4 rounded">
          View All Services
        </a>
      </div>
{{--
      <div class="m-8 text-center w-2"> --}}
        {{-- <x-button>View all services</x-button>   --}}
        {{-- <a
          href="#"
          class="block w-full rounded bg-pink-500 px-12 py-3 text-lg font-medium text-white shadow hover:bg-pink-700 focus:outline-none focus:ring active:bg-pink-500 sm:w-auto"
        >
  Browse Services    </a> --}}

    </section>

    {{-- Gallery --}}
    <section class="pt-5 pb-5">
        <div class="mx-auto text-center md:max-w-xl lg:max-w-3xl">
          <h3 class="text-3xl text-pink-500 font-bold">Gallery</h3>
        </div>
        <div class="container mx-auto px-5 py-2 lg:px-32 lg:pt-12">
          <div class="-m-1 flex flex-wrap md:-m-2">
            <div class="flex w-1/3 flex-wrap">
              <div class="w-full p-1 md:p-2">
                <img
                  alt="gallery"
                  class="block h-full w-full rounded-lg object-cover object-center"
                  src="images/gallery/gallery1.jpg" />
              </div>
            </div>
            <div class="flex w-1/3 flex-wrap">
              <div class="w-full p-1 md:p-2">
                <img
                  alt="gallery"
                  class="block h-full w-full rounded-lg object-cover object-center"
                  src="images/gallery/gallery2.jpg" />
              </div>
            </div>
            <div class="flex w-1/3 flex-wrap">
              <div class="w-full p-1 md:p-2">
                <img
                  alt="gallery"
                  class="block h-full w-full rounded-lg object-cover object-center"
                  src="images/gallery/gallery3.jpg" />
              </div>
            </div>
            <div class="flex w-1/3 flex-wrap">
              <div class="w-full p-1 md:p-2">
                <img
                  alt="gallery"
                  class="block h-full w-full rounded-lg object-cover object-center"
                  src="images/gallery/gallery4.jpg" />
              </div>
            </div>
            <div class="flex w-1/3 flex-wrap">
              <div class="w-full p-1 md:p-2">
                <img
                  alt="gallery"
                  class="block h-full w-full rounded-lg object-cover object-center"
                  src="images/gallery/gallery5.jpg" />
              </div>
            </div>
            <div class="flex w-1/3 flex-wrap">
              <div class="w-full p-1 md:p-2">
                <img
                  alt="gallery"
                  class="block h-full w-full rounded-lg object-cover object-center"
                  src="images/gallery/gallery6.jpg" />
              </div>
            </div>
          </div>
        </div>
    </section>
    <!-- {{-- Testimonials --}}
    <section class="bg-white pt-5">
      <div class="md:w-3/4 mx-auto">
        <div class="mx-auto text-center md:max-w-xl lg:max-w-3xl">
          <h3 class="mb-6 text-3xl text-pink-500 font-bold">Testimonials</h3>
          <p class="mb-6 pb-2 text-gray-700 md:mb-12 md:pb-0">
            Here are the testimonials from our customers who have visited our salon.
          </p>
        </div>

        <div class="grid gap-6 text-center p-6 md:grid-cols-3 lg:gap-12">
          <div class="mb-12 md:mb-0">
            <div class="mb-6 flex justify-center">
              <img src="https://tecdn.b-cdn.net/img/Photos/Avatars/img%20(1).jpg" class="w-32 rounded-full shadow-lg dark:shadow-black/30">
            </div>
            <h5 class="mb-4 text-xl font-semibold">Kim Wexler</h5>
            <h6 class="mb-4 font-semibold text-primary dark:text-primary-400">
              Lawyer
            </h6>
            <p class="mb-4 text-neutral-500">
              <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="inline-block h-7 w-7 pr-2" viewBox="0 0 24 24">
                <path d="M13 14.725c0-5.141 3.892-10.519 10-11.725l.984 2.126c-2.215.835-4.163 3.742-4.38 5.746 2.491.392 4.396 2.547 4.396 5.149 0 3.182-2.584 4.979-5.199 4.979-3.015 0-5.801-2.305-5.801-6.275zm-13 0c0-5.141 3.892-10.519 10-11.725l.984 2.126c-2.215.835-4.163 3.742-4.38 5.746 2.491.392 4.396 2.547 4.396 5.149 0 3.182-2.584 4.979-5.199 4.979-3.015 0-5.801-2.305-5.801-6.275z"></path>
              </svg>
              I had the most amazing experience at Salon Bliss! The staff were so friendly and welcoming, and my hair looked absolutely stunning. I received so many compliments after my appointment and I can't wait to go back!
            </p>
            <ul class="mb-0 flex items-center justify-center">
              <li>
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="h-5 w-5 text-yellow-500">
                  <path fill-rule="evenodd" d="M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.007 5.404.433c1.164.093 1.636 1.545.749 2.305l-4.117 3.527 1.257 5.273c.271 1.136-.964 2.033-1.96 1.425L12 18.354 7.373 21.18c-.996.608-2.231-.29-1.96-1.425l1.257-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305l5.404-.433 2.082-5.006z" clip-rule="evenodd"></path>
                </svg>
              </li>
              <li>
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="h-5 w-5 text-yellow-500">
                  <path fill-rule="evenodd" d="M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.007 5.404.433c1.164.093 1.636 1.545.749 2.305l-4.117 3.527 1.257 5.273c.271 1.136-.964 2.033-1.96 1.425L12 18.354 7.373 21.18c-.996.608-2.231-.29-1.96-1.425l1.257-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305l5.404-.433 2.082-5.006z" clip-rule="evenodd"></path>
                </svg>
              </li>
              <li>
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="h-5 w-5 text-yellow-500">
                  <path fill-rule="evenodd" d="M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.007 5.404.433c1.164.093 1.636 1.545.749 2.305l-4.117 3.527 1.257 5.273c.271 1.136-.964 2.033-1.96 1.425L12 18.354 7.373 21.18c-.996.608-2.231-.29-1.96-1.425l1.257-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305l5.404-.433 2.082-5.006z" clip-rule="evenodd"></path>
                </svg>
              </li>
              <li>
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="h-5 w-5 text-yellow-500">
                  <path fill-rule="evenodd" d="M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.007 5.404.433c1.164.093 1.636 1.545.749 2.305l-4.117 3.527 1.257 5.273c.271 1.136-.964 2.033-1.96 1.425L12 18.354 7.373 21.18c-.996.608-2.231-.29-1.96-1.425l1.257-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305l5.404-.433 2.082-5.006z" clip-rule="evenodd"></path>
                </svg>
              </li>
              <li>
                <svg clip-rule="evenodd" fill-rule="evenodd" fill="currentColor" class="h-5 w-5 text-yellow-500" stroke-linejoin="round" stroke-miterlimit="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                  <path d="m11.322 2.923c.126-.259.39-.423.678-.423.289 0 .552.164.678.423.974 1.998 2.65 5.44 2.65 5.44s3.811.524 6.022.829c.403.055.65.396.65.747 0 .19-.072.383-.231.536-1.61 1.538-4.382 4.191-4.382 4.191s.677 3.767 1.069 5.952c.083.462-.275.882-.742.882-.122 0-.244-.029-.355-.089-1.968-1.048-5.359-2.851-5.359-2.851s-3.391 1.803-5.359 2.851c-.111.06-.234.089-.356.089-.465 0-.825-.421-.741-.882.393-2.185 1.07-5.952 1.07-5.952s-2.773-2.653-4.382-4.191c-.16-.153-.232-.346-.232-.535 0-.352.249-.694.651-.748 2.211-.305 6.021-.829 6.021-.829s1.677-3.442 2.65-5.44zm.678 2.033v11.904l4.707 2.505-.951-5.236 3.851-3.662-5.314-.756z" fill-rule="nonzero"></path>
                </svg>
              </li>
            </ul>
          </div>
          <div class="mb-12 md:mb-0">
            <div class="mb-6 flex justify-center">
              <img src="https://tecdn.b-cdn.net/img/Photos/Avatars/img%20(2).jpg" class="w-32 rounded-full shadow-lg dark:shadow-black/30">
            </div>
            <h5 class="mb-4 text-xl font-semibold">Lisa Cudrow</h5>
            <h6 class="mb-4 font-semibold text-primary dark:text-primary-400">
              Graphic Designer
            </h6>
            <p class="mb-4 text-neutral-500">
              <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="inline-block h-7 w-7 pr-2" viewBox="0 0 24 24">
                <path d="M13 14.725c0-5.141 3.892-10.519 10-11.725l.984 2.126c-2.215.835-4.163 3.742-4.38 5.746 2.491.392 4.396 2.547 4.396 5.149 0 3.182-2.584 4.979-5.199 4.979-3.015 0-5.801-2.305-5.801-6.275zm-13 0c0-5.141 3.892-10.519 10-11.725l.984 2.126c-2.215.835-4.163 3.742-4.38 5.746 2.491.392 4.396 2.547 4.396 5.149 0 3.182-2.584 4.979-5.199 4.979-3.015 0-5.801-2.305-5.801-6.275z"></path>
              </svg>
              "I had the best haircut of my life at Salon Bliss! The stylist listened to exactly what I wanted and then gave me a haircut that exceeded my expectations. I felt so pampered and taken care of throughout the whole process. I can't wait to come back for my next appointment!
            </p>
            <ul class="mb-0 flex items-center justify-center">
              <li>
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="h-5 w-5 text-yellow-500">
                  <path fill-rule="evenodd" d="M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.007 5.404.433c1.164.093 1.636 1.545.749 2.305l-4.117 3.527 1.257 5.273c.271 1.136-.964 2.033-1.96 1.425L12 18.354 7.373 21.18c-.996.608-2.231-.29-1.96-1.425l1.257-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305l5.404-.433 2.082-5.006z" clip-rule="evenodd"></path>
                </svg>
              </li>
              <li>
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="h-5 w-5 text-yellow-500">
                  <path fill-rule="evenodd" d="M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.007 5.404.433c1.164.093 1.636 1.545.749 2.305l-4.117 3.527 1.257 5.273c.271 1.136-.964 2.033-1.96 1.425L12 18.354 7.373 21.18c-.996.608-2.231-.29-1.96-1.425l1.257-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305l5.404-.433 2.082-5.006z" clip-rule="evenodd"></path>
                </svg>
              </li>
              <li>
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="h-5 w-5 text-yellow-500">
                  <path fill-rule="evenodd" d="M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.007 5.404.433c1.164.093 1.636 1.545.749 2.305l-4.117 3.527 1.257 5.273c.271 1.136-.964 2.033-1.96 1.425L12 18.354 7.373 21.18c-.996.608-2.231-.29-1.96-1.425l1.257-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305l5.404-.433 2.082-5.006z" clip-rule="evenodd"></path>
                </svg>
              </li>
              <li>
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="h-5 w-5 text-yellow-500">
                  <path fill-rule="evenodd" d="M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.007 5.404.433c1.164.093 1.636 1.545.749 2.305l-4.117 3.527 1.257 5.273c.271 1.136-.964 2.033-1.96 1.425L12 18.354 7.373 21.18c-.996.608-2.231-.29-1.96-1.425l1.257-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305l5.404-.433 2.082-5.006z" clip-rule="evenodd"></path>
                </svg>
              </li>
              <li>
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="h-5 w-5 text-yellow-500">
                  <path fill-rule="evenodd" d="M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.007 5.404.433c1.164.093 1.636 1.545.749 2.305l-4.117 3.527 1.257 5.273c.271 1.136-.964 2.033-1.96 1.425L12 18.354 7.373 21.18c-.996.608-2.231-.29-1.96-1.425l1.257-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305l5.404-.433 2.082-5.006z" clip-rule="evenodd"></path>
                </svg>
              </li>
            </ul>
          </div>
          <div class="mb-0">
            <div class="mb-6 flex justify-center">
              <img src="https://tecdn.b-cdn.net/img/Photos/Avatars/img%20(4).jpg" class="w-32 rounded-full shadow-lg dark:shadow-black/30">
            </div>
            <h5 class="mb-4 text-xl font-semibold">Jane Smith</h5>
            <h6 class="mb-4 font-semibold text-primary dark:text-primary-400">
              Marketing Specialist
            </h6>
            <p class="mb-4 text-neutral-500">
              <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="inline-block h-7 w-7 pr-2" viewBox="0 0 24 24">
                <path d="M13 14.725c0-5.141 3.892-10.519 10-11.725l.984 2.126c-2.215.835-4.163 3.742-4.38 5.746 2.491.392 4.396 2.547 4.396 5.149 0 3.182-2.584 4.979-5.199 4.979-3.015 0-5.801-2.305-5.801-6.275zm-13 0c0-5.141 3.892-10.519 10-11.725l.984 2.126c-2.215.835-4.163 3.742-4.38 5.746 2.491.392 4.396 2.547 4.396 5.149 0 3.182-2.584 4.979-5.199 4.979-3.015 0-5.801-2.305-5.801-6.275z"></path>
              </svg>
              "I had a last-minute hair emergency and Salon Bliss saved the day! The staff were able to fit me in right away and they did an amazing job. I can't thank them enough for their professionalism and expertise. I will definitely be coming back!"
            </p>
            <ul class="mb-0 flex items-center justify-center">
              <li>
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="h-5 w-5 text-yellow-500">
                  <path fill-rule="evenodd" d="M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.007 5.404.433c1.164.093 1.636 1.545.749 2.305l-4.117 3.527 1.257 5.273c.271 1.136-.964 2.033-1.96 1.425L12 18.354 7.373 21.18c-.996.608-2.231-.29-1.96-1.425l1.257-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305l5.404-.433 2.082-5.006z" clip-rule="evenodd"></path>
                </svg>
              </li>
              <li>
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="h-5 w-5 text-yellow-500">
                  <path fill-rule="evenodd" d="M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.007 5.404.433c1.164.093 1.636 1.545.749 2.305l-4.117 3.527 1.257 5.273c.271 1.136-.964 2.033-1.96 1.425L12 18.354 7.373 21.18c-.996.608-2.231-.29-1.96-1.425l1.257-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305l5.404-.433 2.082-5.006z" clip-rule="evenodd"></path>
                </svg>
              </li>
              <li>
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="h-5 w-5 text-yellow-500">
                  <path fill-rule="evenodd" d="M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.007 5.404.433c1.164.093 1.636 1.545.749 2.305l-4.117 3.527 1.257 5.273c.271 1.136-.964 2.033-1.96 1.425L12 18.354 7.373 21.18c-.996.608-2.231-.29-1.96-1.425l1.257-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305l5.404-.433 2.082-5.006z" clip-rule="evenodd"></path>
                </svg>
              </li>
              <li>
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="h-5 w-5 text-yellow-500">
                  <path fill-rule="evenodd" d="M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.007 5.404.433c1.164.093 1.636 1.545.749 2.305l-4.117 3.527 1.257 5.273c.271 1.136-.964 2.033-1.96 1.425L12 18.354 7.373 21.18c-.996.608-2.231-.29-1.96-1.425l1.257-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305l5.404-.433 2.082-5.006z" clip-rule="evenodd"></path>
                </svg>
              </li>
              <li>
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" class="h-5 w-5 text-yellow-500" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M11.48 3.499a.562.562 0 011.04 0l2.125 5.111a.563.563 0 00.475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 00-.182.557l1.285 5.385a.562.562 0 01-.84.61l-4.725-2.885a.563.563 0 00-.586 0L6.982 20.54a.562.562 0 01-.84-.61l1.285-5.386a.562.562 0 00-.182-.557l-4.204-3.602a.563.563 0 01.321-.988l5.518-.442a.563.563 0 00.475-.345L11.48 3.5z"></path>
                </svg>
              </li>
            </ul>
          </div>
        </div>
      </div>

    </section> -->


    <!-- <section class="mb-12" id="offer-banner">

      <div class="bg-pink-600 alert alert-dismissible fade show fixed bottom-0 right-0 left-0 z-[1030] w-full py-4 px-6 text-white md:flex justify-between items-center text-center md:text-left">
        <div class="mb-4 md:mb-0 flex items-center flex-wrap justify-center md:justify-start">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512" class="w-4 h-4 mr-2">
            <path fill="currentColor" d="M216 23.86c0-23.8-30.65-32.77-44.15-13.04C48 191.85 224 200 224 288c0 35.63-29.11 64.46-64.85 63.99-35.17-.45-63.15-29.77-63.15-64.94v-85.51c0-21.7-26.47-32.23-41.43-16.5C27.8 213.16 0 261.33 0 320c0 105.87 86.13 192 192 192s192-86.13 192-192c0-170.29-168-193-168-296.14z"/>
          </svg>
          <strong class="mr-1">Limited offer!</strong> Get massive discounts now before it's to late
        </div>
        <div class="flex items-center justify-center">
          <a class="inline-block px-6 py-2.5 bg-white text-gray-700 font-semibold text-xs leading-tight uppercase rounded shadow-md hover:bg-gray-100 hover:shadow-lg focus:bg-gray-100 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-gray-200 active:shadow-lg transition duration-150 ease-in-out mr-4" href="#" role="button" data-mdb-ripple="true" data-mdb-ripple-color="light">Claim offer</a>


          <div class="text-white" data-bs-dismiss="alert" aria-label="Close" id="offer-banner-close">
            <svg class="w-4 h-4" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 352 512"><path fill="currentColor" d="M242.72 256l100.07-100.07c12.28-12.28 12.28-32.19 0-44.48l-22.24-22.24c-12.28-12.28-32.19-12.28-44.48 0L176 189.28 75.93 89.21c-12.28-12.28-32.19-12.28-44.48 0L9.21 111.45c-12.28 12.28-12.28 32.19 0 44.48L109.28 256 9.21 356.07c-12.28 12.28-12.28 32.19 0 44.48l22.24 22.24c12.28 12.28 32.2 12.28 44.48 0L176 322.72l100.07 100.07c12.28 12.28 32.2 12.28 44.48 0l22.24-22.24c12.28-12.28 12.28-32.19 0-44.48L242.72 256z"></path></svg>
          </div>
        </div>
      </div>

    </section> -->
    <!-- Footer container -->
    <x-footer />
<script>
  // hide offer-banner when user clicks on close
  document.getElementById("offer-banner-close").addEventListener("click", function() {
    document.getElementById("offer-banner").style.display = "none";
  });

</script>

</x-app-layout>
