<?php

namespace App\Http\Livewire;

use App\Models\LoyaltySetting;
use Livewire\Component;

class CustomerLoyaltyPoints extends Component
{
    public function redeemReward($rewardId)
    {
        $user = auth()->user();
        $loyaltyPoints = $user->loyaltyPoints;
        
        if (!$loyaltyPoints) {
            session()->flash('error', 'No loyalty points account found.');
            return;
        }
    
        $reward = LoyaltySetting::find($rewardId);
        if (!$reward) {
            session()->flash('error', 'Reward not found.');
            return;
        }
    
        if ($loyaltyPoints->canRedeem($reward->points_required)) {
            $loyaltyPoints->redeemPoints($reward->points_required);
            $this->emit('pointsUpdated');
            session()->flash('message', 'Reward redeemed successfully!');
        } else {
            session()->flash('error', 'Insufficient points for this reward.');
        }
    }

    public function render()
    {
        $rewards = LoyaltySetting::where('is_active', true)->get();
        return view('livewire.customer-loyalty-points', [
            'rewards' => $rewards
        ]);
    }
}