<div>
    @if (session()->has('message'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
            {{ session('message') }}
        </div>
    @endif

    @if (session()->has('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
            {{ session('error') }}
        </div>
    @endif

    @foreach($rewards as $reward)
        <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
            <div class="flex justify-between items-center">
                <div>
                    <h4 class="font-semibold">{{ $reward->name }}</h4>
                    <p class="text-sm text-gray-600">{{ $reward->points_required }} points required</p>
                </div>
                <button 
                    wire:click="redeemReward({{ $reward->id }})"
                    class="bg-pink-500 text-white px-4 py-2 rounded hover:bg-pink-600 disabled:opacity-50"
                    @if(!auth()->user()->loyaltyPoints || auth()->user()->loyaltyPoints->points_balance < $reward->points_required) disabled @endif
                >
                    Redeem
                </button>
            </div>
        </div>
    @endforeach
</div>