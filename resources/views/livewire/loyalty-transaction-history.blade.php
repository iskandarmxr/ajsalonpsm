<div class="p-4">
    <div class="overflow-x-auto">
        <table class="min-w-full bg-white rounded-lg overflow-hidden">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Customer Info</th>
                    <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Points Earned</th>
                    <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Points Redeemed</th>
                    <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Current Balance</th>
                    <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider text-center">Transaction History</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @foreach($customers as $customer)
                    <tr>
                        <td class="px-6 py-4">
                            <div class="text-sm font-medium text-gray-900">{{ $customer->name }}</div>
                            <div class="text-sm text-gray-500">{{ $customer->email }}</div>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-900">
                            {{ $customer->loyaltyPoints->total_points_earned }}
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-900">
                            {{ $customer->loyaltyPoints->points_redeemed }}
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-900">
                            {{ $customer->loyaltyPoints->points_balance }}
                        </td>
                        <td class="px-6 py-4 text-sm text-center">
                        <button 
                                wire:click="showTransactionHistory({{ $customer->id }})"
                                class="text-pink-500 hover:text-pink-600 transition-colors duration-200"
                                title="View Transaction History">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Transaction History Modal -->
    <x-dialog-modal wire:model="showingTransactionModal" maxWidth="4xl">
        <x-slot name="title">
            {{ __('Transaction History') }}
        </x-slot>

        <x-slot name="content">
            <div class="mt-4">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Points</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Description</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @if($selectedCustomer)
                            @foreach($selectedCustomer->loyaltyTransactions()->latest()->get() as $transaction)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                            {{ $transaction->type === 'earn' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                            {{ ucfirst($transaction->type) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $transaction->points }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $transaction->description }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $transaction->created_at->format('M d, Y H:i') }}
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </x-slot>

        <x-slot name="footer">
            <div class="flex justify-end">
                <x-secondary-button wire:click="$set('showingTransactionModal', false)" onclick="window.location.reload();" wire:loading.attr="disabled">
                    {{ __('Close') }}
                </x-secondary-button>
            </div>
        </x-slot>
    </x-dialog-modal>
</div>