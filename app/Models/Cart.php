<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $fillable = [
        'uuid',
        'user_id',
        'is_paid',
        'is_cancelled',
        'is_abandoned',
        'total',
    ];


    protected $with = ['services'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function services()
    {
        return $this
            ->belongsToMany(Service::class)
            ->with('locations')
            ->withPivot('id','time_slot_id','date', 'start_time', 'end_time', 'location_id' , 'price');

    }

    public function markAsPaid()
    {
        $this->is_paid = true;
        $this->save();
        
        // Create a new cart for the user
        $newCart = self::create([
            'user_id' => $this->user_id,
            'is_paid' => false,
            'is_cancelled' => false,
            'is_abandoned' => false,
            'total' => 0
        ]);
        
        return $newCart;
    }

    public function clearServices()
    {
        $this->services()->detach();
    }
    
    protected static function booted()
    {
        static::creating(function ($cart) {
            $cart->uuid = \Illuminate\Support\Str::uuid();
        });
    }

}
