<?php

namespace App\Models;

use App\Enums\UserRolesEnum;
use App\Enums\AppointmentStatusEnum;
use App\Jobs\SendAppointmentConfirmationMailJob;
use App\Jobs\SendNewServicePromoMailJob;
use App\Jobs\SendAppointmentStatusChangeJob;
use App\Jobs\SendLoyaltyPointsEarnedJob;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    protected $fillable = [
        'appointment_code',
        'cart_id',
        'user_id',
        'service_id',
        'date',
        'time_slot_id',
        'start_time',
        'end_time',
        'location_id',
        'total',
        'status',
    ];

    protected $casts = [
        'start_time' => 'string',  // as string cuz we get it from the time slot
        'end_time' => 'string',
        'status' => AppointmentStatusEnum::class
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function timeSlot()
    {
        return $this->belongsTo(TimeSlot::class);
    }

    public function cart()
    {
        return $this->belongsTo(Cart::class);
    }

    public function location()
    {
        return $this->belongsTo(Location::class);
    }
    public function assigned_staff()
    {
        return $this->belongsTo(User::class, 'assigned_staff_id');
    }

    protected static function booted()
    {
        static::created(function ($appointment) {
            if ($appointment->status === AppointmentStatusEnum::Completed) {
                $loyaltyPoints = CustomerLoyaltyPoints::firstOrCreate(
                    ['user_id' => $appointment->user_id]
                );
                
                $settings = LoyaltySetting::first();
                if ($settings) {
                    $pointsEarned = $settings->points_per_appointment;
                    $loyaltyPoints->points_balance += $pointsEarned;
                    $loyaltyPoints->total_points_earned += $pointsEarned;
                    $loyaltyPoints->last_earned_at = now();
                    $loyaltyPoints->save();
                }
            }
        });

        static::updating(function ($appointment) {
            if ($appointment->isDirty('status')) {
                $oldStatus = $appointment->getOriginal('status')->value;
                $newStatus = $appointment->status->value;
                
                SendAppointmentStatusChangeJob::dispatch(
                    $appointment->user,
                    $appointment,
                    $oldStatus,
                    $newStatus
                );
            }
        });   
    }


    static function boot()
    {
        parent::boot();

        static::creating(function ($appointment) {
            // a readable unique code for the appointment, including the id in the code
            $appointment->appointment_code = 'APP-'.  ($appointment->count() + 1) ;

        });
    }


}
