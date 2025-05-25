<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\CustomerLoyaltyPoints;

class CustomerLoyaltyHistory extends Component
{
    public function render()
    {
        $history = auth()->user()->loyaltyPoints ?? new CustomerLoyaltyPoints();
        
        return view('livewire.customer-loyalty-history', [
            'history' => $history
        ]);
    }
}