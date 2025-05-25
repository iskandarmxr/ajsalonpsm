<x-dashboard>
    <div class="p-4">
        <div class="bg-white rounded-lg shadow-lg p-6">
            <!-- Loyalty Card -->
            <div class="mb-8">
                <h2 class="text-2xl font-bold mb-4">My Loyalty Points</h2>
                <div class="bg-pink-500 text-white rounded-lg p-6">
                    <div class="flex justify-between items-center">
                        <div>
                            <p class="text-sm">Current Points Balance</p>
                            <p class="text-3xl font-bold">
                                {{ auth()->user()->loyaltyPoints ? auth()->user()->loyaltyPoints->points_balance : 0 }}
                            </p>
                        </div>
                        <div>
                            <svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Available Rewards -->
            <div class="mb-8">
                <h3 class="text-xl font-semibold mb-4">Available Rewards</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <livewire:customer-loyalty-points />
                </div>
            </div>

            <!-- Points History -->
            <div>
                <h3 class="text-xl font-semibold mb-4">Points History</h3>
                <livewire:customer-loyalty-history />
            </div>
        </div>
    </div>
</x-dashboard>