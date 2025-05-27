<?php

namespace App\Http\Livewire;

use App\Models\Reward;
use App\Models\LoyaltySetting;
use App\Models\LoyaltyTransaction;
use App\Jobs\SendRewardRedeemedJob;
use Livewire\Component;

class CustomerLoyaltyPoints extends Component
{
    public $pointTransactions;

    public function mount()
    {
        $this->loadTransactions();
    }

    public function loadTransactions()
    {
        $this->pointTransactions = LoyaltyTransaction::where('user_id', auth()->id())
        ->orderBy('created_at', 'desc')
        ->get();
    }

    protected function recordTransaction($points, $type, $description, $referenceType = null, $referenceId = null)
    {
        return LoyaltyTransaction::create([
            'user_id' => auth()->id(),
            'points' => $points,
            'type' => $type,
            'description' => $description,
            'reference_type' => $referenceType,
            'reference_id' => $referenceId
        ]);
    }

    public function earnPointsFromAppointment($appointmentId, $points)
    {
        // Update customer_loyalty_points balance
        $loyaltyPoints = auth()->user()->loyaltyPoints;
        $loyaltyPoints->points_balance += $points;
        $loyaltyPoints->total_points_earned += $points;
        $loyaltyPoints->save();

        // Record the transaction
        $this->recordTransaction(
            $points,
            'earned',
            'Points earned from appointment',
            'appointment',
            $appointmentId
        );

        $this->loadTransactions(); // Refresh the transactions list
    }
    
    public function redeemReward($rewardId)
    {
        $user = auth()->user();
        $loyaltyPoints = $user->loyaltyPoints;
        
        if (!$loyaltyPoints) {
            session()->flash('error', 'No loyalty points account found.');
            return;
        }
    
        $reward = Reward::find($rewardId);
        if (!$reward || !$reward->isAvailable()) {
            session()->flash('error', 'Reward not found or not available.');
            return;
        }
    
        if ($loyaltyPoints->canRedeem($reward->points_required)) {
            $pointsRemaining = max(0, $loyaltyPoints->points_balance - $reward->points_required);
            $loyaltyPoints->redeemPoints($reward->points_required, $reward->id);

            // Dispatch the notification job
            SendRewardRedeemedJob::dispatch(
                $user,
                $reward,
                $reward->points_required,
                $pointsRemaining
            );

            $this->emit('pointsUpdated');
            session()->flash('message', "Reward '{$reward->name}' redeemed successfully!");
            $this->loadTransactions(); // Refresh the transactions list
        } else {
            session()->flash('error', 'Insufficient points for this reward.');
        }
    }

    public function render()
    {
        $rewards = Reward::where('is_active', true)
            ->where(function($query) {
                $now = now();
                $query->whereNull('active_from')
                    ->orWhere('active_from', '<=', $now);
            })
            ->where(function($query) {
                $now = now();
                $query->whereNull('expiry_date')
                    ->orWhere('expiry_date', '>=', $now);
            })
            ->get();
            
        $settings = LoyaltySetting::getActiveSettings();
        
        return view('livewire.customer-loyalty-points', [
            'rewards' => $rewards,
            'settings' => $settings
        ]);
    }
}