<?php

namespace App\Enums;

enum AppointmentStatusEnum: string
{
    case Pending = 'pending';
    case Confirmed = 'confirmed';
    case Completed = 'completed';
    case Rejected = 'rejected';
    case Cancelled = 'cancelled';

    public static function getStatusColor($status): string
    {
        return match ($status) {
            self::Pending->value => 'gray',
            self::Confirmed->value => 'sky',
            self::Completed->value => 'emerald',
            self::Rejected->value => 'orange',
            self::Cancelled->value => 'rose',
            default => 'gray'
        };
    }
}