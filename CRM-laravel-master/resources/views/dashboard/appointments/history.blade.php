<x-dashboard>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Appointment History') }}
        </h2>
    </x-slot>

    <div>
        <livewire:manage-appointments />
    </div>
</x-dashboard>