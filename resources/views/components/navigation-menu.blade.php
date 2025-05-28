@php
    use App\Enums\UserRolesEnum;
    $userRole = Auth::User()?->role()->first()->name;
@endphp
<nav x-data="{ open: false }" @click.outside="open = false" @navigate.window="open = false" class="bg-white border-b border-gray-100 z-50 sticky top-0">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <!-- Change this div's class to center content on mobile -->
            <div class="flex flex-1 justify-center sm:justify-start">
                <!-- Logo -->
                @if(isset($mainLogoRoute))
                    @php
                        {{ $appMarkRoute = $mainLogoRoute;}}
                    @endphp
                @else
                    @php
                        {{ $appMarkRoute = route('dashboard'); }}
                    @endphp
                @endif

                <div class="shrink-0 flex items-center">
                    <a href="{{ $appMarkRoute }}" class="flex items-center">
                        <x-application-mark class="block h-9 w-auto" />
                    </a>
                </div>
            </div>
            <div class="hidden sm:flex sm:items-center sm:ml-6">

            <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                @if(!Auth::check() || (Auth::check() && Auth::user()->role_id == UserRolesEnum::Customer->value))
                    <x-nav-link href="{{ route('home') }}" :active="request()->routeIs('home')">
                        {{ __('Home') }}
                    </x-nav-link>
                @endif

                   <!-- Navigation Links for cust facing web-->

                    <x-web.navlinks />

                    <!-- Auth Navigation Links -->
                    @auth
                        @if(Auth::user()->role_id == UserRolesEnum::Customer->value)
                            <x-nav-link href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')">
                                {{ __('Dashboard') }}
                            </x-nav-link>
                        @endif
                    @else
                    <x-nav-link href="{{ route('login') }}" :active="request()->routeIs('login')">
                        {{ __('Login') }}
                    </x-nav-link>

                    <x-nav-link href="{{ route('register') }}" :active="request()->routeIs('register')">
                        {{ __('Register') }}
                    </x-nav-link>
                    @endauth
                    
                </div>

                @auth
                <!-- Teams Dropdown -->
                @if (Laravel\Jetstream\Jetstream::hasTeamFeatures())
                    <div class="ml-3 relative">
                        <x-dropdown align="right" width="60">
                            <x-slot name="trigger">
                                <span class="inline-flex rounded-md">
                                    <button type="button" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none focus:bg-gray-50 active:bg-gray-50 transition ease-in-out duration-150">
                                        {{ Auth::user()->currentTeam->name }}

                                        <svg class="ml-2 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 15L12 18.75 15.75 15m-7.5-6L12 5.25 15.75 9" />
                                        </svg>
                                    </button>
                                </span>
                            </x-slot>

                            <x-slot name="content">
                                <div class="w-60">
                                    <!-- Team Management -->
                                    <div class="block px-4 py-2 text-xs text-gray-400">
                                        {{ __('Manage Team') }}
                                    </div>

                                    <!-- Team Settings -->
                                    <x-dropdown-link href="{{ route('teams.show', Auth::user()->currentTeam->id) }}">
                                        {{ __('Team Settings') }}
                                    </x-dropdown-link>

                                    @can('create', Laravel\Jetstream\Jetstream::newTeamModel())
                                        <x-dropdown-link href="{{ route('teams.create') }}">
                                            {{ __('Create New Team') }}
                                        </x-dropdown-link>
                                    @endcan

                                    <!-- Team Switcher -->
                                    @if (Auth::user()->allTeams()->count() > 1)
                                        <div class="border-t border-gray-200"></div>

                                        <div class="block px-4 py-2 text-xs text-gray-400">
                                            {{ __('Switch Teams') }}
                                        </div>

                                        @foreach (Auth::user()->allTeams() as $team)
                                            <x-switchable-team :team="$team" />
                                        @endforeach
                                    @endif
                                </div>
                            </x-slot>
                        </x-dropdown>
                    </div>
                @endif

                <!-- Settings Dropdown -->
                <div class="ml-3 relative">
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                                <span class="inline-flex rounded-md">
                                    <button type="button" class="inline-flex items-center  px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none focus:bg-gray-50 active:bg-gray-50 transition ease-in-out duration-150">
                                        @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                                        <img class="h-8 w-8 rounded-full object-cover" src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}" />
                                        @endif
                                        <div class="ml-2">
                                            {{ Auth::user()->name }}
                                        </div>
                                             <svg class="ml-2 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                                        </svg>
                                    </button>
                                </span>

                        </x-slot>

                        <x-slot name="content">
                            @if($userRole == 'Customer')
                            <div class="block px-4 py-2 text-xs text-gray-400">
                                {{ __('Shop') }}
                            </div>
                            <x-dropdown-link href="{{ route('cart') }}">
                                {{ __('Cart') }}
                            </x-dropdown-link>
                            <x-dropdown-link href="">
                                {{ __('Booking') }}
                            </x-dropdown-link>
                            <x-dropdown-link href="">
                                {{ __('My Appointments') }}
                            </x-dropdown-link>

                            <div class="border-t border-gray-200"></div>
                            @endif
                            <!-- Account Management -->
                            <div class="block px-4 py-2 text-xs text-gray-400">
                                {{ __('Manage Account') }}
                            </div>

                            <x-dropdown-link href="{{ route('profile.show') }}">
                                {{ __('Profile') }}
                            </x-dropdown-link>

                            @if (Laravel\Jetstream\Jetstream::hasApiFeatures())
                                <x-dropdown-link href="{{ route('api-tokens.index') }}">
                                    {{ __('API Tokens') }}
                                </x-dropdown-link>
                            @endif

                            <div class="border-t border-gray-200"></div>

                            <!-- Authentication -->
                            <form method="POST" action="{{ route('logout') }}" x-data>
                                @csrf

                                <x-dropdown-link href="{{ route('logout') }}"
                                         @click.prevent="$root.submit();">
                                    {{ __('Log Out') }}
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                </div>
                @endif
            </div>

            <!-- Hamburger -->
            <div class="-mr-2 flex items-center sm:hidden"> 
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out"> 
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7C16 9.20914 14.2091 11 12 11C9.79086 11 8 9.20914 8 7C8 4.79086 9.79086 3 12 3C14.2091 3 16 4.79086 16 7ZM12 14C8.13401 14 5 17.134 5 21H19C19 17.134 15.866 14 12 14Z" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button> 
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="lg:hidden">

        <div class="pt-2 pb-3 space-y-1">

            <!-- @if(Auth::check() && Auth::user()->role_id !== UserRolesEnum::Manager->value && Auth::user()->role_id !== UserRolesEnum::Staff->value)
                <x-responsive-nav-link href="{{ route('home') }}" :active="request()->routeIs('home')">
                    {{ __('Home') }}
                </x-responsive-nav-link>
            @endif

            <x-responsive-nav-link href="#">
                {{ __('Services') }}
            </x-responsive-nav-link>

            <x-responsive-nav-link href="#">
                {{ __('Deals') }}
            </x-responsive-nav-link> -->



            @auth
            @if($userRole == 'Admin')
            <x-responsive-nav-link href="{{ route('manageusers') }}" :active="request()->routeIs('manageusers')">
                {{ __('Manage Users') }}
            </x-responsive-nav-link>
            @endif

            <!-- <x-responsive-nav-link href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link> -->

            @else
            <x-responsive-nav-link href="{{ route('login') }}" :active="request()->routeIs('login')">
                {{ __('Login') }}
            </x-responsive-nav-link>

            <x-responsive-nav-link href="{{ route('register') }}" :active="request()->routeIs('register')">
                {{ __('Register') }}
            </x-responsive-nav-link>

            @endif
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            @auth
                <div class="flex items-center px-4">
                    @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                        <div class="shrink-0 mr-3">
                            <img class="h-10 w-10 rounded-full object-cover" src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}" />
                        </div>
                    @endif

                    <div>
                        <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                        <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
                    </div>
                </div>

                <div class="mt-3 space-y-1">
                    <x-responsive-nav-link href="{{ route('services') }}" :active="request()->routeIs('services')">
                        {{ __('Hair Services') }}
                    </x-responsive-nav-link>

                    <x-responsive-nav-link href="{{ route('hairstyles') }}" :active="request()->routeIs('hairstyles')">
                        {{ __('Hairstyles') }}
                    </x-responsive-nav-link>
                    <!-- Account Management -->
                    <x-responsive-nav-link href="{{ route('profile.show') }}" :active="request()->routeIs('profile.show')">
                        {{ __('Profile') }}
                    </x-responsive-nav-link>

                    @if (Laravel\Jetstream\Jetstream::hasApiFeatures())
                        <x-responsive-nav-link href="{{ route('api-tokens.index') }}" :active="request()->routeIs('api-tokens.index')">
                            {{ __('API Tokens') }}
                        </x-responsive-nav-link>
                    @endif

                    <!-- Authentication -->
                    <form method="POST" action="{{ route('logout') }}" x-data>
                        @csrf

                        <x-responsive-nav-link href="{{ route('logout') }}"
                                    @click.prevent="$root.submit();">
                            {{ __('Log Out') }}
                        </x-responsive-nav-link>
                    </form>

                    <!-- Team Management -->
                    @if (Laravel\Jetstream\Jetstream::hasTeamFeatures())
                        <div class="border-t border-gray-200"></div>

                        <div class="block px-4 py-2 text-xs text-gray-400">
                            {{ __('Manage Team') }}
                        </div>

                        <!-- Team Settings -->
                        <x-responsive-nav-link href="{{ route('teams.show', Auth::user()->currentTeam->id) }}" :active="request()->routeIs('teams.show')">
                            {{ __('Team Settings') }}
                        </x-responsive-nav-link>

                        @can('create', Laravel\Jetstream\Jetstream::newTeamModel())
                            <x-responsive-nav-link href="{{ route('teams.create') }}" :active="request()->routeIs('teams.create')">
                                {{ __('Create New Team') }}
                            </x-responsive-nav-link>
                        @endcan

                        <!-- Team Switcher -->
                        @if (Auth::user()->allTeams()->count() > 1)
                            <div class="border-t border-gray-200"></div>

                            <div class="block px-4 py-2 text-xs text-gray-400">
                                {{ __('Switch Teams') }}
                            </div>

                            @foreach (Auth::user()->allTeams() as $team)
                                <x-switchable-team :team="$team" component="responsive-nav-link" />
                            @endforeach
                        @endif
                    @endif
                </div>
            @endif
        </div>
    </div>
</nav>
