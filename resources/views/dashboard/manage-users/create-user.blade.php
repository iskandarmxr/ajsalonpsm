<x-dashboard>

<header class="bg-white shadow">
        <div class="max-w-7xl mx-auto py-4 px-2 sm:px-6 lg:px-8">
            <h2 class="text-2xl font-bold text-gray-900 text-center">Create Users</h2>
        </div>
    </header>

    <div class="pt-4 pb-4">
        <form action="{{ route('users.store')}}" method="post" class="w-1/2 mx-auto bg-white rounded-lg p-5">
            @csrf
            <!-- Name -->
            <div class="col-span-6 sm:col-span-4 my-2">
                <x-label for="name" value="{{ __('Name') }}" />
                <x-input id="name" type="text" class="mt-1 block w-full" name="name" />
                <x-input-error for="name" class="mt-2" />
            </div>
        
            <!-- Email -->
            <div class="col-span-6 sm:col-span-4 my-2">
                <x-label for="email" value="{{ __('Email') }}" />
                <x-input id="email" type="email" class="mt-1 block w-full" name="email" />
                <x-input-error for="email" class="mt-2" />
            </div>

            <!-- Phone Number -->
            <div class="col-span-6 sm:col-span-4 my-2">
                <x-label for="phone_number" value="{{ __('Phone Number') }}" />
                <span class="text-xs">eg: 0112121211</span>
                <x-input id="phone_number" type="text" class="mt-1 block w-full" name="phone_number" />
                <x-input-error for="phone_number" class="mt-2" />
            </div>

            <!-- Password -->
            <div class="col-span-6 sm:col-span-4 my-2">
                <x-label for="password" value="{{ __('Password') }}" />
                <x-input id="password" type="password" class="mt-1 block w-full" name="password"/>
                <x-input-error for="password" class="mt-2" />
            </div>

            <!-- Confirm Password -->
            <div class="col-span-6 sm:col-span-4 my-2">
                <x-label for="password_confirmation" value="{{ __('Confirm Password') }}" />
                <x-input id="password_confirmation" type="password" class="mt-1 block w-full" name="password_confirmation" />
                <x-input-error for="password_confirmation" class="mt-2" />
            </div>

            <!-- Role -->
            <div class="col-span-6 sm:col-span-4 my-2">
                <x-label for="role" value="{{ __('Role') }}" />
                <select name="role" id="role" class="border-gray-300 focus:border-pink-500 focus:ring-pink-500 rounded-md shadow-sm" onchange="toggleLocationField()">
                    <option value="manager">Manager</option>
                    <option value="staff">Staff</option>
                    <option value="customer">Customer</option>
                </select>
                <x-input-error for="role" class="mt-2" />
            </div>

            <!-- Location (for Manager and Staff only) -->
            <div id="locationField" class="col-span-6 sm:col-span-4 my-2" style="display: none;">
                <x-label for="location_id" value="{{ __('Branch Location') }}" />
                <select name="location_id" id="location_id" class="border-gray-300 focus:border-pink-500 focus:ring-pink-500 rounded-md shadow-sm">
                    @foreach(\App\Models\Location::where('status', true)->get() as $location)
                        <option value="{{ $location->id }}">{{ $location->name }}</option>
                    @endforeach
                </select>
                <x-input-error for="location_id" class="mt-2" />
            </div>

            <script>
                function toggleLocationField() {
                    const role = document.getElementById('role').value;
                    const locationField = document.getElementById('locationField');
                    locationField.style.display = (role === 'manager' || role === 'staff') ? 'block' : 'none';
                }
                // Call on page load to set initial state
                toggleLocationField();
            </script>

            <div class="flex items-center justify-end mt-4">
                <x-button class="ml-4">
                    {{ __('Create User') }}
                </x-button>
            </div>
        </form>
    </div>
    <div class="bg-pink-500 p-2 text-center">
        <span class="text-white">© Copyright 2025</span>
        <a
            class="font-semibold text-white hover:text-gray-200 transition"
            href="/admin/dashboard/"
        >
            AJ Hair Salon
        </a>
    </div>
    
</x-dashboard>
