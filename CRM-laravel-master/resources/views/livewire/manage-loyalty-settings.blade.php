<div class="p-6 bg-white rounded-lg shadow-lg">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-gray-800">Loyalty Program Settings</h2>
        <x-button wire:click="toggleEdit" class="bg-pink-500 hover:bg-pink-600">
            {{ $editMode ? 'Cancel' : 'Edit Settings' }}
        </x-button>
    </div>

    @if (session()->has('message'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
            {{ session('message') }}
        </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-700">Points Per Appointment</label>
                @if($editMode)
                    <input type="number" wire:model="settings.points_per_appointment" 
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                @else
                    <p class="mt-1 text-gray-900">{{ $settings->points_per_appointment }}</p>
                @endif
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Points Required for Redemption</label>
                @if($editMode)
                    <input type="number" wire:model="settings.points_required" 
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                @else
                    <p class="mt-1 text-gray-900">{{ $settings->points_required }}</p>
                @endif
            </div>
        </div>

        <div class="space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-700">Discount Percentage</label>
                @if($editMode)
                    <input type="number" wire:model="settings.discount_percentage" 
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                @else
                    <p class="mt-1 text-gray-900">{{ $settings->discount_percentage }}%</p>
                @endif
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Minimum Spend</label>
                @if($editMode)
                    <input type="number" wire:model="settings.minimum_spend" 
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                @else
                    <p class="mt-1 text-gray-900">LKR {{ $settings->minimum_spend }}</p>
                @endif
            </div>
        </div>
    </div>

    @if($editMode)
        <div class="mt-6">
            <x-button wire:click="saveSettings" class="bg-pink-500 hover:bg-pink-600">
                Save Settings
            </x-button>
        </div>
    @endif
</div>