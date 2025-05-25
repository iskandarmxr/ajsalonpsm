@php
    use App\Enums\UserRolesEnum;
@endphp
<x-app-layout>
  <div>

        {{-- Nav links should be passed from here  --}}
        <x-slot name="navlinks">
            <x-dashboard.navlinks />
        </x-slot>

        <!-- Add Font Awesome CDN for icons -->
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" rel="stylesheet">

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
            }

            .modern-sidebar.collapsed {
                width: var(--sidebar-width-collapsed);
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
                    <div class="sidebar-divider hide-on-collapse">Configure</div>
                    <a href="{{ route('managelocations') }}" 
                        class="sidebar-link {{ request()->is('dashboard/manage/locations') ? 'active' : '' }}">
                        <i class="fas fa-store"></i>
                        <span class="hide-on-collapse">Locations</span>
                    </a>
                    <a href="{{ route('manageservices') }}" 
                        class="sidebar-link {{ request()->is('dashboard/manage/services') ? 'active' : '' }}">
                        <i class="fas fa-cut"></i>
                        <span class="hide-on-collapse">Hair Services</span>
                    </a>
                    <a href="{{ route('managehairstyles') }}" 
                        class="sidebar-link {{ request()->is('dashboard/manage/hairstyles') ? 'active' : '' }}">
                        <i class="fas fa-paint-brush"></i>
                        <span class="hide-on-collapse">Hairstyle</span>
                    </a>
                    <a href="{{ route('managecategories') }}" 
                        class="sidebar-link {{ request()->is('dashboard/manage/categories') ? 'active' : '' }}">
                        <i class="fas fa-tags"></i>
                        <span class="hide-on-collapse">Hair Service Categories</span>
                    </a>
                    <a href="{{ route('managehairstylecategories') }}" 
                        class="sidebar-link {{ request()->is('dashboard/manage/hairstyle-categories') ? 'active' : '' }}">
                        <i class="fas fa-folder"></i>
                        <span class="hide-on-collapse">Hairstyle Categories</span>
                    </a>
                    <a href="{{ route('manageloyalty') }}" 
                        class="sidebar-link {{ request()->is('dashboard/manage/loyalty') ? 'active' : '' }}">
                        <i class="fas fa-award"></i>
                        <span class="hide-on-collapse">Loyalty</span>
                    </a>
                    @endif
                    @endif
                </div>
            </div>

            <!-- Main Content -->
            <div class="main-content">
                @if (session('errormsg'))
                    <div class="mb-4 font-medium text-sm text-red-600">
                        {{ session('errormsg') }}
                    </div>
                @endif

                @if (session('success'))
                    <div class="mb-4 font-medium text-sm text-green-600">
                        {{ session('success') }}
                    </div>
                @endif

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

