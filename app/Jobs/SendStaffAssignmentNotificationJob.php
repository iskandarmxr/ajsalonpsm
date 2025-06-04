<?php

namespace App\Jobs;

use App\Models\Appointment;
use App\Models\User;
use App\Notifications\StaffAssignmentNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Notification;

class SendStaffAssignmentNotificationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        public User $staff,
        public Appointment $appointment,
        public bool $isAssigned
    ) {}

    public function handle(): void
    {
        $notification = new StaffAssignmentNotification(
            $this->appointment,
            $this->isAssigned
        );

        Notification::send($this->staff, $notification);
    }
}