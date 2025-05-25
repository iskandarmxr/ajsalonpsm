<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CartService extends Model
{
    protected $table = 'cart_service';

    protected $fillable = [
        'cart_id',
        'service_id',
        'time_slot_id',
        'location_id',
        'date',
        'start_time',
        'end_time',
        'price'
    ];

    public function cart()
    {
        return $this->belongsTo(Cart::class);
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function timeSlot()
    {
        return $this->belongsTo(TimeSlot::class);
    }

    public function location()
    {
        return $this->belongsTo(Location::class);
    }
}