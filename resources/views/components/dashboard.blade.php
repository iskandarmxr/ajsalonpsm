@php
    use App\Enums\UserRolesEnum;
@endphp
<x-app-layout>
  <div>

        {{-- Nav links should be passed from here  --}}
        <x-slot name="navlinks">
            <x-dashboard.navlinks />
        </x-slot>

        <!-- Mobile toggle button with hamburger style -->
        <div class="-mr-2 flex items-center lg:hidden fixed top-4 left-4 z-50">
            <button class="mobile-sidebar-toggle inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                    <path class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>
        </div>

        <style>
            :root {
                --sidebar-width: 280px;
                --sidebar-width-collapsed: 80px;
                --primary-color: #e91e63;
                --sidebar-bg: linear-gradient(135deg, #1a1c2e 0%, #16181f 100%);
                --text-light: #a0a3bd;
                --text-active: #ffffff;
            }

            #dashboard-grid {
                display: grid;
                transition: all 0.3s ease;
            }

            .modern-sidebar {
                width: var(--sidebar-width);
                height: 100vh;
                background: var(--sidebar-bg);
                transition: all 0.3s ease;
                position: fixed;
                overflow-y: auto;
                overflow-x: hidden;
                z-index: 20;
                scrollbar-width: thin;
                scrollbar-color: var(--primary-color) var(--sidebar-bg);
                flex-direction: column;
            }

                /* Custom scrollbar styling */
            .modern-sidebar::-webkit-scrollbar {
                width: 6px;
            }

            .modern-sidebar::-webkit-scrollbar-track {
                background: var(--sidebar-bg);
            }

            .modern-sidebar::-webkit-scrollbar-thumb {
                background-color: var(--primary-color);
                border-radius: 3px;
                border: 2px solid var(--sidebar-bg);
            }

            .modern-sidebar.collapsed {
                width: var(--sidebar-width-collapsed);
            }

            .sidebar-content {
                padding-bottom: 8rem; /* Add padding at the bottom for better scrolling */
                min-height: 100%; /* Ensure content takes full height minus header */
                display: flex;
                flex-direction: column;
                flex: 1;
            }

            .toggle-btn {
                position: absolute;
                right: -15px;
                top: 20px;
                background: white;
                border-radius: 50%;
                width: 30px;
                height: 30px;
                border: none;
                box-shadow: 0 2px 6px rgba(0, 0, 0, 0.15);
                z-index: 100;
                cursor: pointer;
                transition: transform 0.3s ease;
                display: flex;
                align-items: center;
                justify-content: center;
            }

            .collapsed .toggle-btn {
                transform: rotate(180deg);
            }

            .sidebar-header {
                padding: 1.5rem;
            }

            .logo-text {
                background: linear-gradient(45deg, #ff6b8b, #e91e63);
                -webkit-background-clip: text;
                -webkit-text-fill-color: transparent;
                margin-bottom: 0;
                font-weight: bold;
                font-size: 1.4rem;
                transition: opacity 0.3s ease;
            }

            .sidebar-divider {
                color: var(--text-light);
                font-size: 0.875rem;
                padding: 0 1.5rem;
                margin: 1rem 0 0.5rem;
            }

            .sidebar-link {
                color: var(--text-light);
                transition: all 0.2s ease;
                border-radius: 8px;
                margin: 0.25rem 1rem;
                padding: 0.75rem 1rem;
                display: flex;
                align-items: center;
                white-space: nowrap;
                overflow: hidden;
                text-decoration: none;
            }

            .sidebar-link:hover {
                color: var(--text-active);
                background: rgba(255, 255, 255, 0.1);
                transform: translateX(5px);
            }

            .sidebar-link.active {
                color: var(--text-active);
                background: rgba(233, 30, 99, 0.2);
                border-left: 4px solid var(--primary-color);
            }

            .sidebar-link i, .sidebar-link svg {
                margin-right: 1rem;
                width: 20px;
                height: 20px;
            }

            .profile-section {
                margin-top: auto;
                padding: 1.5rem;
                border-top: 1px solid rgba(255, 255, 255, 0.1);
            }

            .main-content {
                margin-left: var(--sidebar-width);
                min-height: 100vh;
                transition: all 0.3s ease;
                width: calc(100% - var(--sidebar-width));
            }

            .collapsed ~ .main-content {
                margin-left: var(--sidebar-width-collapsed);
                width: calc(100% - var(--sidebar-width-collapsed));
            }

            .hide-on-collapse {
                transition: opacity 0.2s ease;
            }

            .collapsed .hide-on-collapse {
                opacity: 0;
                visibility: hidden;
                display: none;
            }

            .collapsed .logo-text {
                opacity: 0;
            }

            .collapsed .sidebar-link {
                text-align: center;
                justify-content: center;
            }

            .collapsed .sidebar-link i, .collapsed .sidebar-link svg {
                margin-right: 0;
            }

            .collapsed .sidebar-divider {
                opacity: 0;
            }

            /* Responsive adjustments */
            @media (max-width: 1024px) {
                .modern-sidebar {
                    width: var(--sidebar-width-collapsed);
                    transform: translateX(-100%);
                }
                
                .modern-sidebar.mobile-visible {
                    transform: translateX(0);
                    width: var(--sidebar-width);
                }
                
                .main-content {
                    margin-left: 0;
                    width: 100%;
                }
                
                .mobile-sidebar-toggle {
                    display: block;
                }
                
                .toggle-btn {
                    display: none;
                }
            }
        </style>

        <div id="dashboard-grid" class="grid grid-cols-1">
            <!-- Modern Sidebar -->
            <div class="modern-sidebar" id="modern-sidebar">
                <button class="toggle-btn" onclick="toggleSidebar()">
                    <i class="fas fa-chevron-left"></i>
                </button>

                <div class="sidebar-content">
                    {{-- User Role 1= Admin, 2 = Employee --}}
                    @if(Auth::user()->role_id == UserRolesEnum::Customer->value)
                    <a href="{{ route('home') }}" 
                        class="sidebar-link {{ request()->routeIs('home') ? 'active' : '' }}">
                        <i class="fas fa-chart-line"></i>
                        <span class="hide-on-collapse">Home</span>
                    </a>
                    <a href="{{ route('appointments.history') }}" 
                        class="sidebar-link {{ request()->routeIs('appointments.history') ? 'active' : '' }}">
                        <i class="fas fa-clock"></i>
                        <span class="hide-on-collapse">Appointment History</span>
                    </a>
                    <a href="{{ route('customer.loyalty') }}" 
                        class="sidebar-link {{ request()->is('dashboard/loyalty') ? 'active' : '' }}">
                        <i class="fas fa-coins"></i>
                        <span class="hide-on-collapse">My Loyalty Points</span>
                    </a>
                    @endif

                    @if(Auth::user()->role_id == UserRolesEnum::Manager->value || Auth::user()->role_id == UserRolesEnum::Staff->value)
                    <a href="{{ route('dashboard') }}" 
                        class="sidebar-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                        <i class="fas fa-chart-line"></i>
                        <span class="hide-on-collapse">Overview</span>
                    </a>
                    <div class="sidebar-divider hide-on-collapse">Manage</div>
                    <a href="{{ route('appointment.schedule') }}" 
                        class="sidebar-link {{ request()->is('dashboard/appointment-schedule') ? 'active' : '' }}">
                        <i class="fas fa-calendar-alt"></i>
                        <span class="hide-on-collapse">Appointment Schedule</span>
                    </a>
                    @if(Auth::user()->role_id == UserRolesEnum::Manager->value)
                    <a href="{{ route('manageusers') }}" 
                        class="sidebar-link {{ request()->is('dashboard/manage/users') ? 'active' : '' }}">
                        <i class="fas fa-users"></i>
                        <span class="hide-on-collapse">Users</span>
                    </a>
                    @endif
                    <a href="{{ route('manageappointments') }}" 
                        class="sidebar-link {{ request()->is('dashboard/manage/appointments') ? 'active' : '' }}">
                        <i class="fas fa-calendar-check"></i>
                        <span class="hide-on-collapse">Appointments</span>
                    </a>
                    @if(Auth::user()->role_id == UserRolesEnum::Manager->value)
                    <a href="{{ route('manageservices') }}" 
                        class="sidebar-link {{ request()->is('dashboard/manage/services') ? 'active' : '' }}">
                        <i class="fas fa-cut"></i>
                        <span class="hide-on-collapse">Hair Services</span>
                    </a>
                    <a href="{{ route('managehairstyles') }}" 
                        class="sidebar-link {{ request()->is('dashboard/manage/hairstyles') ? 'active' : '' }}">
                        <i class="fas fa-paint-brush"></i>
                        <span class="hide-on-collapse">Hairstyles</span>
                    </a>
                    @endif
                    
                    @if(Auth::user()->role_id == UserRolesEnum::Manager->value)
                    <div class="sidebar-divider hide-on-collapse">Configure</div>
                    <a href="{{ route('managelocations') }}" 
                        class="sidebar-link {{ request()->is('dashboard/manage/locations') ? 'active' : '' }}">
                        <i class="fas fa-store"></i>
                        <span class="hide-on-collapse">Locations</span>
                    </a>
                    <a href="{{ route('managecategories') }}" 
                        class="sidebar-link {{ request()->is('dashboard/manage/categories') ? 'active' : '' }}">
                        <i class="fas fa-tags"></i>
                        <span class="hide-on-collapse">Hair Services</span>
                    </a>
                    <a href="{{ route('managehairstylecategories') }}" 
                        class="sidebar-link {{ request()->is('dashboard/manage/hairstyle-categories') ? 'active' : '' }}">
                        <i class="fas fa-folder"></i>
                        <span class="hide-on-collapse">Hairstyles</span>
                    </a>
                    <div class="sidebar-divider hide-on-collapse">Loyalty Program</div>
                    <a href="{{ route('manageloyalty') }}" 
                        class="sidebar-link {{ request()->is('dashboard/manage/loyalty') ? 'active' : '' }}">
                        <i class="fas fa-cog"></i>
                        <span class="hide-on-collapse">Program Settings</span>
                    </a>
                    <a href="{{ route('loyalty.transactions') }}" 
                        class="sidebar-link {{ request()->is('dashboard/loyalty/transactions') ? 'active' : '' }}">
                        <i class="fas fa-history"></i>
                        <span class="hide-on-collapse">Loyalty Transactions</span>
                    </a>
                    <a href="{{ route('managerewards') }}" 
                        class="sidebar-link {{ request()->is('dashboard/manage/rewards') ? 'active' : '' }}">
                        <i class="fas fa-gift"></i>
                        <span class="hide-on-collapse">Rewards</span>
                    </a>
                    @endif
                    @endif
                </div>
            </div>

            <!-- Main Content -->
            <div class="main-content">
                <!-- @if (session('errormsg'))
                    <div class="mb-4 font-medium text-sm text-red-600">
                        {{ session('errormsg') }}
                    </div>
                @endif -->

                <!-- @if (session('success'))
                    <div class="mb-4 font-medium text-sm text-green-600">
                        {{ session('success') }}
                    </div>
                @endif -->

                <div>
                    {{ $slot }}
                </div>
            </div>
        </div>

        <script>
            // Sidebar toggle functionality
            function toggleSidebar() {
                const sidebar = document.getElementById('modern-sidebar');
                const dashboardGrid = document.getElementById('dashboard-grid');
                
                sidebar.classList.toggle('collapsed');
                
                // Save state in localStorage
                localStorage.setItem('sidebarCollapsed', sidebar.classList.contains('collapsed'));
            }
            
            // Check saved state on load
            document.addEventListener('DOMContentLoaded', function() {
                const sidebar = document.getElementById('modern-sidebar');
                const savedState = localStorage.getItem('sidebarCollapsed');
                
                if (savedState === 'true') {
                    sidebar.classList.add('collapsed');
                }
                
                // Mobile sidebar toggle
                const mobileToggle = document.querySelector('.mobile-sidebar-toggle');
                if (mobileToggle) {
                    mobileToggle.addEventListener('click', function() {
                        const sidebar = document.getElementById('modern-sidebar');
                        sidebar.classList.toggle('mobile-visible');
                    });
                }
            });
        </script>
  </div>
</x-app-layout>

