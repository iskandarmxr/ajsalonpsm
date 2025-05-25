<?php

namespace App\Jobs;

use App\Models\Appointment;
use App\Models\User;
use App\Notifications\AppointmentStatusChangeNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Notification;

class SendAppointmentStatusChangeJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        public User $customer,
        public Appointment $appointment,
        public string $oldStatus,
        public string $newStatus
    )
    {
    }

    public function handle(): void
    {
        $notification = new AppointmentStatusChangeNotification(
            $this->appointment,
            $this->oldStatus,
            $this->newStatus
        );

        Notification::send($this->customer, $notification);
    }
}