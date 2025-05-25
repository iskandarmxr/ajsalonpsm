<div class="bg-white rounded-lg shadow overflow-hidden">
    <div class="p-4">
        <div class="grid grid-cols-2 gap-4 mb-4">
            <div class="bg-pink-50 p-4 rounded-lg">
                <p class="text-sm text-gray-600">Total Points Earned</p>
                <p class="text-2xl font-bold text-pink-600">{{ $history->total_points_earned ?? 0 }}</p>
            </div>
            <div class="bg-pink-50 p-4 rounded-lg">
                <p class="text-sm text-gray-600">Total Points Redeemed</p>
                <p class="text-2xl font-bold text-pink-600">{{ $history->points_redeemed ?? 0 }}</p>
            </div>
        </div>

        <div class="mt-4">
            <p class="text-sm text-gray-600">Last Points Earned</p>
            <p class="text-gray-800">
                {{ $history->last_earned_at ? $history->last_earned_at->format('M d, Y H:i') : 'No points earned yet' }}
            </p>
        </div>
    </div>
</div>