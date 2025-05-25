<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
        $this->points_balance += $points;
        $this->total_points_earned += $points;
        $this->last_earned_at = now();
        $this->save();
    }

    public function redeemPoints($points)
    {
        if ($this->canRedeem($points)) {
            $this->points_balance -= $points;
            $this->points_redeemed += $points;
            $this->save();
            return true;
        }
        return false;
    }
}