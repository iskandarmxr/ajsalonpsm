<?php

namespace App\Notifications;

use App\Models\Appointment;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewAppointmentNotificationForManager extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public Appointment $appointment
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
            ->subject('New Appointment Booking - AJ Hair Salon 📅')
            ->greeting('Hello ' . $notifiable->name . '!')
            ->line('A new appointment has been booked!')
            ->line('🧾 Appointment Code: ' . $this->appointment->appointment_code)
            ->line('👤 Customer: ' . $this->appointment->user->name)
            ->line('💇‍♀️ Service: ' . $this->appointment->service->name)
            ->line('📅 Date: ' . $this->appointment->date)
            ->line('⏰ Time: ' . $this->appointment->timeSlot->start_time . ' - ' . $this->appointment->timeSlot->end_time)
            ->line('📍 Location: ' . $this->appointment->location->name)
            ->line('💲 Total: RM' . $this->appointment->total)
            ->action('View Appointment', route('manageappointments'))
            ->line('Please assign a staff member to handle this appointment.');
    }

    public function toArray($notifiable): array
    {
        return [];
    }
}