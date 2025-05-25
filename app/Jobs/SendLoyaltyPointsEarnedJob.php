<?php

namespace App\Jobs;

use App\Models\User;
use App\Models\CustomerLoyaltyPoints;
use App\Notifications\LoyaltyPointsEarnedNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Notification;

class SendLoyaltyPointsEarnedJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        public User $customer,
        public int $pointsEarned
    ) {}

    public function handle(): void
    {
        $notification = new LoyaltyPointsEarnedNotification($this->pointsEarned);
        Notification::send($this->customer, $notification);
    }
}