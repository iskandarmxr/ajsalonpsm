<?php

namespace App\Notifications;

use App\Models\Appointment;
use App\Models\Service;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AppointmentConfirmationNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public Appointment $appointment,
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
            ->subject( 'Appointment Confirmation - AJ Hair Salon 🎉' . $this->appointment->service->name)
            ->from('noreply@salonbliss.com')
            ->greeting('Hello ' . $notifiable->name . '!')
            ->line('Your appointment for ' . $this->appointment->service->name . ' has been confirmed!')
            // invoice
            ->line('🧾 Appointment Code: ' . $this->appointment->appointment_code)
            ->line('💲 Payment: RM' . $this->appointment->total)
            ->line('📅 Date: ' . $this->appointment->date)
            ->line('⏰ Time: ' . $this->appointment->start_time . ' - ' . $this->appointment->end_time)
            ->line('📍 Location: ' . $this->appointment->location->name)
            ->line('📍 Address: ' . $this->appointment->location->address)
            ->line('📞 Contact: ' . $this->appointment->location->telephone_number)
            ->action('View Your Appointment',  route('appointments.history'))
            ->line('Thank you for using AJ Hair Salon! We hope to see you again soon.');

    }

    public function toArray($notifiable): array
    {
        return [];
    }
}
