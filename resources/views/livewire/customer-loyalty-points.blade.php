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

    <!-- Loyalty Membership Card -->
    <div class="bg-gradient-to-r from-blue-500 to-blue-700 rounded-lg shadow-lg p-6 mb-6 text-white">
        <div class="flex justify-between items-center mb-4">
            <div>
                <h2 class="text-2xl font-bold">Loyalty Card</h2>
                <p class="text-sm opacity-80">Grab Your Chance to Receive Hair Service for FREE!</p>
                <p class="text-sm mt-2">Join our loyalty program and save on<br>every completed appointment!</p>
            </div>
            <div class="text-right">
                <p class="text-sm">Balance</p>
                <div class="flex items-center justify-end">
                    <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span class="text-2xl font-bold">{{ auth()->user()->loyaltyPoints ? auth()->user()->loyaltyPoints->points_balance : 0 }}</span>
                </div>
                @php
                    $settings = \App\Models\LoyaltySetting::getActiveSettings();
                @endphp
                @if($settings)
                    <p class="text-xs mt-1">Earn {{ $settings->points_per_appointment }} points per completed appointment</p>
                    <p class="text-xs">*Requires at least ONE(1) completed appointment to activate.</p>
                @endif
            </div>
        </div>
        
        <div class="flex justify-between items-end mt-4">
            <div>
                <p class="text-xs opacity-80">Identifier</p>
                <p class="font-mono">{{ auth()->user()->id }}-{{ substr(md5(auth()->user()->email), 0, 10) }}</p>
            </div>
            
            <div class="bg-white p-2 rounded-lg">
                <div class="qr-code w-24 h-24 flex items-center justify-center">
                    <svg class="w-full h-full" viewBox="0 0 100 100">
                        <!-- Simple QR code placeholder -->
                        <rect x="10" y="10" width="80" height="80" fill="none" stroke="#000" stroke-width="1"/>
                        <path d="M20,20 h20 v20 h-20 z M60,20 h20 v20 h-20 z M20,60 h20 v20 h-20 z M40,40 h20 v20 h-20 z M65,65 h10 v10 h-10 z" fill="#000"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <div x-data="{ activeTab: 'rewards' }">
        <!-- Tabs Navigation -->
        <div class="border-b border-gray-200 mb-6">
            <ul class="flex -mb-px">
                <li class="mr-2">
                    <button @click="activeTab = 'rewards'" :class="{'border-pink-500 text-pink-600': activeTab === 'rewards', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': activeTab !== 'rewards'}"
                    class="inline-block py-4 px-4 text-sm font-medium border-b-2 focus:outline-none">Rewards</button>
                </li>
                <li class="mr-2">
                    <button @click="activeTab = 'history'" :class="{'border-pink-500 text-pink-600': activeTab === 'history', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': activeTab !== 'history'}"
                    class="inline-block py-4 px-4 text-sm font-medium border-b-2 focus:outline-none">History</button>
                </li>
                <li class="mr-2">
                    <button @click="activeTab = 'rules'" :class="{'border-pink-500 text-pink-600': activeTab === 'rules', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': activeTab !== 'rules'}"
                    class="inline-block py-4 px-4 text-sm font-medium border-b-2 focus:outline-none">Rules</button>
                </li>
            </ul>
        </div>
    
        <!-- Tab Content -->
        <div>
            <div x-show="activeTab === 'rewards'">
                <!-- Rewards content -->
                @foreach($rewards as $reward)
                    <div class="bg-gray-50 rounded-lg p-4 border border-gray-200 mb-4">
                        <div class="flex justify-between items-center">
                            <div>
                                <h4 class="font-semibold">{{ $reward->name }}</h4>
                                <p class="text-sm text-gray-600">{{ $reward->description }}</p>
                                <p class="text-sm text-gray-600">{{ $reward->points_required }} points required</p>
                                @if($reward->active_from || $reward->expiry_date)
                                    <p class="text-xs text-gray-500">
                                        Valid: 
                                        {{ $reward->active_from ? $reward->active_from->format('M d, Y') : 'Always' }}
                                        -
                                        {{ $reward->expiry_date ? $reward->expiry_date->format('M d, Y') : 'No expiry' }}
                                    </p>
                                @endif
                            </div>
                            @if($reward->image_path)
                                <img src="{{ Storage::url($reward->image_path) }}" 
                                    alt="{{ $reward->name }}" 
                                    class="h-16 w-16 rounded-lg object-cover">
                            @endif
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
    
        <!-- History Tab -->
        <div x-show="activeTab === 'history'" class="space-y-4">
            <div class="grid grid-cols-2 gap-4 mb-4">
                <div class="bg-pink-50 p-4 rounded-lg">
                    <p class="text-sm text-gray-600">Total Points Earned</p>
                    <p class="text-2xl font-bold text-pink-600">{{ auth()->user()->loyaltyPoints ? auth()->user()->loyaltyPoints->total_points_earned : 0 }}</p>
                </div>
                <div class="bg-pink-50 p-4 rounded-lg">
                    <p class="text-sm text-gray-600">Total Points Redeemed</p>
                    <p class="text-2xl font-bold text-pink-600">{{ auth()->user()->loyaltyPoints ? auth()->user()->loyaltyPoints->points_redeemed : 0 }}</p>
                </div>
            </div>

            <!-- Transaction History -->
            <!--DataTable CSS -->
            <link href="//cdn.datatables.net/2.3.0/css/dataTables.dataTables.min.css" rel="stylesheet">
            <!-- End DataTable CSS -->
            <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
                <div class="divide-y divide-gray-200">
                    <div class="p-4 bg-gray-50 border-b border-gray-200">
                        <div class="flex justify-between items-center">
                            <div>
                                <h3 class="text-lg font-semibold">Transaction History</h3>
                                <p class="text-sm text-gray-600">Your loyalty points activity. Please show this to the staff for
                                    reward redemption confirmation.</p>
                            </div>
                        </div>
                    </div>
                    
                        <table id="transactionHistory" class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border-r">Type</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border-r">Points</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border-r">Description</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border-r">Date</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach(auth()->user()->loyaltyTransactions()->latest()->get() as $transaction)
                                <tr>
                                    <td class="px-1 py-1 whitespace-nowrap border-r">
                                        <div class="flex items-center">
                                            <div class="bg-{{ $transaction->type === 'earn' ? 'green' : 'red' }}-100 p-2 rounded-full mr-3">
                                                <svg class="w-5 h-5 text-{{ $transaction->type === 'earn' ? 'green' : 'red' }}-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    @if($transaction->type === 'earn')
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                                    @else
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path>
                                                    @endif
                                                </svg>
                                            </div>
                                            {{ ucfirst($transaction->type) }}
                                        </div>
                                    </td>
                                    <td class="px-1 py-1 whitespace-nowrap border-r text-{{ $transaction->type === 'earn' ? 'green' : 'red' }}-500">
                                        {{ $transaction->type === 'earn' ? '+' : '' }}{{ $transaction->points }}
                                    </td>
                                    <td class="px-1 py-1 text-sm text-left whitespace-nowrap border-r">{{ $transaction->description }}
                                        @if($transaction->type === 'earn' && $transaction->expires_at)
                                            <span class="text-gray-500 text-xs">
                                                (Expires: {{ $transaction->expires_at->format('M d, Y') }})
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-1 py-1 text-sm text-left whitespace-nowrap">{{ $transaction->created_at->diffForHumans() }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    
                </div>
            </div>
        </div>

        <!-- Rules Tab -->
        <div x-show="activeTab === 'rules'" class="space-y-4">
            <div class="bg-white rounded-lg border border-gray-200 p-6">
                <h3 class="text-lg font-semibold mb-4">Rules and Conditions</h3>
                <ul class="space-y-4 list-disc pl-5">
                    @php
                        $settings = \App\Models\LoyaltySetting::first();
                    @endphp
                    @if($settings && $settings->loyalty_rules)
                        @foreach($settings->loyalty_rules as $rule)
                            <li>{{ $rule }}</li>
                        @endforeach
                    @endif
                </ul>
            </div>
        </div>

        <!-- Reward Redemption Modal -->
        <div 
            x-show="showModal" 
            class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 z-50"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
        >
            <div 
                class="bg-white rounded-lg shadow-xl max-w-md w-full overflow-hidden"
                x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 transform scale-95"
                x-transition:enter-end="opacity-100 transform scale-100"
                x-transition:leave="transition ease-in duration-200"
                x-transition:leave-start="opacity-100 transform scale-100"
                x-transition:leave-end="opacity-0 transform scale-95"
                @click.away="showModal = false"
            >
                <div class="p-6" x-data="{ showQR: false }">
                    <div x-show="!showQR">
                        <div class="flex justify-between items-start">
                            <h3 class="text-lg font-semibold" x-text="selectedReward?.name"></h3>
                            <button @click="showModal = false" class="text-gray-400 hover:text-gray-500">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </button>
                        </div>
                        
                        <div class="mt-4 bg-gray-100 rounded-lg p-4 flex items-center justify-center">
                            <!-- Reward image placeholder -->
                            <svg class="w-24 h-24 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12zm-7 4h14M5 12a2 2 0 110-4h14a2 2 0 110 4M5 12v7a2 2 0 002 2h10a2 2 0 002-2v-7"></path>
                            </svg>
                        </div>
                        
                        <div class="mt-4">
                            <p class="text-sm text-gray-600">Reward Description</p>
                            <p class="mt-1">Enjoy this exclusive reward as a thank you for your loyalty!</p>
                        </div>
                        
                        <div class="mt-4 bg-blue-50 p-4 rounded-lg">
                            <div class="flex justify-between">
                                <div>
                                    <p class="text-sm text-gray-600">Current Balance</p>
                                    <p class="font-semibold">{{ auth()->user()->loyaltyPoints ? auth()->user()->loyaltyPoints->points_balance : 0 }} points</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-600">Cost</p>
                                    <p class="font-semibold" x-text="`${selectedReward?.points_required} points`"></p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mt-6">
                            <button 
                                @click="showQR = true; $wire.redeemReward(selectedReward.id)"
                                class="w-full bg-pink-500 text-white px-4 py-3 rounded-lg hover:bg-pink-600 flex items-center justify-center"
                            >
                                <span class="mr-2">→ Claim Reward</span>
                            </button>
                        </div>
                    </div>
                    
                    <div x-show="showQR" class="text-center">
                        <div class="flex justify-between items-start mb-4">
                            <h3 class="text-lg font-semibold">Show this QR code to an employee</h3>
                            <button @click="showModal = false" class="text-gray-400 hover:text-gray-500">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </button>
                        </div>
                        
                        <p class="text-sm text-gray-600 mb-4">
                            You have {{ auth()->user()->loyaltyPoints ? auth()->user()->loyaltyPoints->points_balance : 0 }} points. After claiming this reward, you will have 
                            <span x-text="{{ auth()->user()->loyaltyPoints ? auth()->user()->loyaltyPoints->points_balance : 0 }} - selectedReward?.points_required"></span> points remaining.
                        </p>
                        
                        <div class="bg-white border-2 border-gray-200 p-4 rounded-lg inline-block">
                            <!-- QR Code for staff to scan -->
                            <svg class="w-64 h-64" viewBox="0 0 100 100">
                                <!-- Simple QR code placeholder -->
                                <rect x="5" y="5" width="90" height="90" fill="none" stroke="#000" stroke-width="1"/>
                                <path d="M15,15 h25 v25 h-25 z M60,15 h25 v25 h-25 z M15,60 h25 v25 h-25 z M45,45 h10 v10 h-10 z M60,60 h5 v5 h-5 z M70,60 h5 v5 h-5 z M60,70 h5 v5 h-5 z M70,70 h5 v5 h-5 z M80,60 h5 v5 h-5 z M60,80 h5 v5 h-5 z M70,80 h5 v5 h-5 z M80,80 h5 v5 h-5 z" fill="#000"/>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/2.3.0/js/dataTables.min.js"></script>
    <script>
            document.addEventListener('livewire:load', function () {
                let table = new DataTable('#transactionHistory', {
                    responsive: true,
                    pageLength: 10,
                    lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
                    order: [[3, 'desc']], // Sort by date column descending
                    language: {
                        search: "Search transactions:",
                        zeroRecords: "No transactions found",
                        lengthMenu: "Show _MENU_ transactions per page",
                    },
                    columnDefs: [
                        { className: "px-4 py-2 text-center", targets: [0, 1] }, // Center align only Type and Points columns
                        { className: "px-4 py-2 text-left", targets: [2, 3] }   // Left align Description and Date columns
                    ]
                });

                // Reinitialize table when Livewire updates
                Livewire.on('transactionUpdated', () => {
                    table.destroy();
                    table = new DataTable('#transactionHistory', {
                        responsive: true,
                        order: [[3, 'desc']],
                        pageLength: 10,
                        lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
                        language: {
                            search: "Search transactions:",
                            zeroRecords: "No transactions found"
                        },
                        columnDefs: [
                            { className: "px-4 py-2 text-center", targets: [0, 1] }, // Center align only Type and Points columns
                            { className: "px-4 py-2 text-left", targets: [2, 3] }   // Left align Description and Date columns
                        ]
                    });
                });
            });
    </script>
</div>