<?php

namespace App\Jobs;

use App\Models\User;
use App\Models\Reward;
use App\Notifications\RewardRedemptionNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Notification;

class SendRewardRedeemedJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        public User $customer,
        public Reward $reward,
        public int $pointsUsed,
        public int $pointsRemaining
    ) {}

    public function handle(): void
    {
        $notification = new RewardRedemptionNotification(
            $this->reward,
            $this->pointsUsed,
            $this->pointsRemaining
        );

        Notification::send($this->customer, $notification);
    }
}