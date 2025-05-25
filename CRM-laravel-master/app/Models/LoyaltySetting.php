<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LoyaltySetting extends Model
{
    protected $fillable = [
        'name',
        'points_required',
        'discount_percentage',
        'points_per_appointment',
        'minimum_spend',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'discount_percentage' => 'decimal:2',
    ];

    public static function getActiveSettings()
    {
        return self::where('is_active', true)->first();
    }
}