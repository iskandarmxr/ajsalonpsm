<x-dashboard>
    <header class="bg-white shadow">
        <div class="max-w-7xl mx-auto py-4 px-2 sm:px-6 lg:px-8">
            <h2 class="text-2xl font-bold text-gray-900 text-center">Reward Management</h2>
            <p class="text-gray-600 text-center">Manage rewards and redemption points for loyalty program</p>
        </div>
    </header>
    <div class="p-4">

        <!-- Rewards Management Component -->
        <div class="bg-white rounded-lg shadow-lg">
            <livewire:manage-rewards />
        </div>
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