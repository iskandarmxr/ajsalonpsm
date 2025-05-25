<x-dashboard>
    <div class="p-4">
        <h2 class="text-2xl font-bold mb-4">Loyalty Program Management</h2>
        
        <!-- Stats Cards Row -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
            <div class="bg-pink-500 shadow-lg rounded-md flex items-center justify-between p-3 border-b-4 border-pink-600 text-white font-medium group">
                <div class="flex justify-center items-center w-14 h-14 bg-white rounded-full">
                    <svg class="w-8 h-8 text-pink-800" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div class="text-right">
                    <p class="text-2xl">{{ App\Models\CustomerLoyaltyPoints::count() }}</p>
                    <p>Active Members</p>
                </div>
            </div>
            
            <div class="bg-pink-500 shadow-lg rounded-md flex items-center justify-between p-3 border-b-4 border-pink-600 text-white font-medium group">
                <div class="flex justify-center items-center w-14 h-14 bg-white rounded-full">
                    <svg class="w-8 h-8 text-pink-800" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div class="text-right">
                    <p class="text-2xl">{{ App\Models\CustomerLoyaltyPoints::sum('points_redeemed') }}</p>
                    <p>Total Points Redeemed</p>
                </div>
            </div>
            
            <div class="bg-pink-500 shadow-lg rounded-md flex items-center justify-between p-3 border-b-4 border-pink-600 text-white font-medium group">
                <div class="flex justify-center items-center w-14 h-14 bg-white rounded-full">
                    <svg class="w-8 h-8 text-pink-800" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 11l3-3m0 0l3 3m-3-3v8m0-13a9 9 0 110 18 9 9 0 010-18z"/>
                    </svg>
                </div>
                <div class="text-right">
                    <p class="text-2xl">{{ App\Models\CustomerLoyaltyPoints::sum('points_balance') }}</p>
                    <p>Active Points</p>
                </div>
            </div>
        </div>

        <!-- Settings Component -->
        <div class="bg-white rounded-lg shadow-lg">
            <livewire:manage-loyalty-settings />
        </div>
    </div>
</x-dashboard>