<?php

namespace App\Notifications;

use App\Models\Appointment;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class StaffAssignmentNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public Appointment $appointment,
        public bool $isAssigned
    ) {}

    public function via($notifiable): array
    {
        return ['mail'];
    }

    public function toMail($notifiable): MailMessage
    {
        $action = $this->isAssigned ? 'assigned to' : 'unassigned from';
        
        return (new MailMessage)
            ->subject($this->isAssigned ? 'New Appointment Assignment - AJ Hair Salon 📅' : 'Appointment Unassignment - AJ Hair Salon 📅')
            ->greeting('Hello ' . $notifiable->name . '!')
            ->line("You have been {$action} an appointment.")
            ->line('🧾 Appointment Code: ' . $this->appointment->appointment_code)
            ->line('👤 Customer: ' . $this->appointment->user->name)
            ->line('💇‍♀️ Service: ' . $this->appointment->service->name)
            ->line('📅 Date: ' . $this->appointment->date)
            ->line('⏰ Time: ' . $this->appointment->timeSlot->start_time . ' - ' . $this->appointment->timeSlot->end_time)
            ->line('📍 Location: ' . $this->appointment->location->name)
            ->action('View Appointment Details', route('manageappointments'))
            ->line('Thank you for your service at AJ Hair Salon!');
    }

    public function toArray($notifiable): array
    {
        return [];
    }
}