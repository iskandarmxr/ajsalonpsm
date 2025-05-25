<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\LoyaltyTransaction;
use App\Models\CustomerLoyaltyPoints;
use Carbon\Carbon;

class DeductExpiredPoints extends Command
{
    protected $signature = 'loyalty:deduct-expired';
    protected $description = 'Deduct expired loyalty points from users';

    public function handle()
    {
        $expiredTransactions = LoyaltyTransaction::where('type', 'earn')
            ->whereNotNull('expires_at')
            ->where('expires_at', '<=', now())
            ->where('is_expired', false)
            ->get();

        foreach ($expiredTransactions as $transaction) {
            $customerPoints = CustomerLoyaltyPoints::where('user_id', $transaction->user_id)->first();
            
            if ($customerPoints) {
                // Deduct the expired points from balance
                $customerPoints->points_balance -= $transaction->points;
                $customerPoints->save();

                // Mark the transaction as expired
                $transaction->is_expired = true;
                $transaction->save();

                // Create a new transaction record for the expiration
                LoyaltyTransaction::create([
                    'user_id' => $transaction->user_id,
                    'points' => -$transaction->points,
                    'type' => 'expire',
                    'description' => 'Points expired',
                    'reference_id' => $transaction->id
                ]);
            }
        }

        $this->info('Expired points have been deducted successfully.');
    }
}