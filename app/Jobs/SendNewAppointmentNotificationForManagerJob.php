<?php

namespace App\Jobs;

use App\Models\Appointment;
use App\Models\User;
use App\Enums\UserRolesEnum;
use App\Notifications\NewAppointmentNotificationForManager;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Notification;

class SendNewAppointmentNotificationForManagerJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        public Appointment $appointment
    ) {}

    public function handle(): void
    {
        // Get managers for the specific location
        $managers = User::where('role_id', UserRolesEnum::Manager->value)
                       ->where('location_id', $this->appointment->location_id)
                       ->get();
        
        $notification = new NewAppointmentNotificationForManager($this->appointment);
        
        Notification::send($managers, $notification);
    }
}