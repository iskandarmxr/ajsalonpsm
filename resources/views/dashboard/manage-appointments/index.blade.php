<?php
    use App\Enums\AppointmentStatusEnum;
    use App\Enums\UserRolesEnum;
?>

<x-dashboard>
<header class="bg-white shadow">
        <div class="max-w-7xl mx-auto py-4 px-2 sm:px-6 lg:px-8">
            @if(Auth::user()->role_id == UserRolesEnum::Staff->value)
            <h2 class="text-2xl font-bold text-gray-900 text-center">Assigned Appointments</h2>
            <p class="text-gray-600 text-center">Manage and track your assigned appointments efficiently</p>
            @else
            <h2 class="text-2xl font-bold text-gray-900 text-center">Manage Appointments</h2>
            <p class="text-gray-600 text-center">Oversee and coordinate all appointments to ensure smooth operations</p>
            @endif
        </div>
    </header>
    <div wire:poll.10s>
        <livewire:manage-appointments :select-filter="'all'" />
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
