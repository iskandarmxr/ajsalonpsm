<?php

namespace App\Notifications;

use App\Models\Reward;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class RewardRedemptionNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public Reward $reward,
        public int $pointsUsed,
        public int $pointsRemaining
    ) {}

    public function via($notifiable): array
    {
        return ['mail'];
    }

    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Reward Redeemed Successfully! 🎉 - AJ Hair Salon')
            ->greeting('Hi ' . $notifiable->name . '!')
            ->line('Congratulations! You\'ve successfully redeemed your reward:')
            ->line('🎁 **Reward**: ' . $this->reward->name)
            ->line('📅 **Date Redeemed**: ' . now()->format('d M, Y'))
            ->line('💰 **Points Used**: '. $this->pointsUsed)
            ->line('💳 **Points Remaining**: '. $this->pointsRemaining)
            ->line('Your reward is now active and can be used at your next visit. Just show this email at the counter or let our staff know.')
            ->line('Thank you for being a loyal customer! We appreciate your continued support.')
            ->action('Check Your Rewards Dashboard', url('/dashboard/dashboard/loyalty'))
            ->line('If you have any questions, feel free to contact us at support@ajsalon.com or call the nearest branch.')
            ->salutation('Best regards, AJ Hair Salon Team');
    }
}