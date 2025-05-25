<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\CustomerLoyaltyPoints;
use App\Models\User;

class LoyaltyTransactionHistory extends Component
{
    public $showingTransactionModal = false;
    public $selectedCustomer = null;
    
    public function render()
    {
        $customers = User::whereHas('loyaltyPoints')
            ->with(['loyaltyPoints', 'loyaltyTransactions'])
            ->get();

        return view('livewire.loyalty-transaction-history', [
            'customers' => $customers
        ]);
    }

    public function showTransactionHistory($customerId)
    {
        $this->selectedCustomer = User::with('loyaltyTransactions')
            ->findOrFail($customerId);
        $this->showingTransactionModal = true;
    }
}