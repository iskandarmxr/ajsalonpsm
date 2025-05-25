<?php

namespace App\Notifications;

use App\Models\CustomerLoyaltyPoints;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class LoyaltyPointsEarnedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public int $pointsEarned
    ) {}

    public function via($notifiable): array
    {
        return ['mail'];
    }

    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('You Earned Loyalty Points! 🎉')
            ->greeting('Hello ' . $notifiable->name . '!')
            ->line('Congratulations! You have earned ' . $this->pointsEarned . ' loyalty points for your recent appointment.')
            ->line('Thank you for being a valued customer!');
    }
}