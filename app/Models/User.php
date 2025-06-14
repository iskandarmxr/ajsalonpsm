<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone_number',
        'role_id',
        'status',

    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'profile_photo_url',
    ];

    function role() {
        return $this->belongsTo(Role::class);
    }

    function cart() {
        return $this->hasOne(Cart::class);
    }

    public function loyaltyPoints()
    {
        return $this->hasOne(CustomerLoyaltyPoints::class);
    }

    public function loyaltyTransactions()
{
    return $this->hasMany(LoyaltyTransaction::class);
}

        /**
     * Get the appointments assigned to the staff member.
     */
    public function assignedAppointments()
    {
        return $this->hasMany(Appointment::class, 'assigned_staff_id');
    }
    public function location()
    {
        return $this->belongsTo(Location::class);
    }
}

