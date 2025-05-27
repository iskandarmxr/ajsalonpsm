<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Jobs\SendLoyaltyPointsEarnedJob;

class CustomerLoyaltyPoints extends Model
{
    protected $fillable = [
        'user_id',
        'points_balance',
        'total_points_earned',
        'points_redeemed',
        'last_earned_at'
    ];

    protected $casts = [
        'last_earned_at' => 'datetime'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    

    public function canRedeem($pointsRequired)
    {
        return $this->points_balance >= $pointsRequired;
    }

    public function addPoints($points)
    {
        $this->points_balance = ($this->points_balance ?? 0) + $points;
        $this->total_points_earned = ($this->total_points_earned ?? 0) + $points;
        $this->last_earned_at = now();
        $this->save();
        $expiryDate = now()->addMonths(6);
        // Create transaction record
        LoyaltyTransaction::create([
            'user_id' => $this->user_id,
            'points' => $points,
            'type' => 'earn',
            'description' => 'Gained Loyalty Points',
            'expires_at' => $expiryDate
        ]);
        $user = $this->user;
        $pointsEarned = $points;
        SendLoyaltyPointsEarnedJob::dispatch(
            $user,
            $pointsEarned);

        return $this;
    }

    public function redeemPoints($points, $rewardId = null)
    {
        if ($this->canRedeem($points)) {
            $this->points_balance = max(0, $this->points_balance - $points);
            $this->points_redeemed += $points;
            $this->save();

            // Create transaction record for points redeemed
            $reward = $rewardId ? Reward::find($rewardId) : null;
            LoyaltyTransaction::create([
                'user_id' => $this->user_id,
                'points' => -$points,
                'type' => 'redeem',
                'description' => $reward ? "Reward Claimed: {$reward->name}" : 'Points Redeemed',
                'reward_id' => $rewardId
            ]);

            return true;
        }
        return false;
    }

    public function transactions()
    {
        return $this->hasMany(LoyaltyTransaction::class, 'user_id', 'user_id');
    }
}