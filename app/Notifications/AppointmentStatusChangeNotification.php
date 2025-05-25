<?php

namespace App\Notifications;

use App\Models\Appointment;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AppointmentStatusChangeNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public Appointment $appointment,
        public string $oldStatus,
        public string $newStatus
    )
    {
    }

    public function via($notifiable): array
    {
        return ['mail'];
    }

    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Appointment Status Update - AJ Hair Salon 🔔')
            ->from('noreply@salonbliss.com')
            ->greeting('Hello ' . $notifiable->name . '!')
            ->line('Your appointment status has been updated!')
            ->line('🧾 Appointment Code: ' . $this->appointment->appointment_code)
            ->line('💇‍♀️ Service: ' . $this->appointment->service->name)
            ->line('📅 Date: ' . $this->appointment->date)
            ->line('⏰ Time: ' . $this->appointment->start_time . ' - ' . $this->appointment->end_time)
            ->line('ℹ️ Status changed from: ' . $this->oldStatus . ' to ' . $this->newStatus)
            ->action('View Your Appointment', route('appointments.history'))
            ->line('Thank you for choosing AJ Hair Salon!');
    }

    public function toArray($notifiable): array
    {
        return [];
    }
}