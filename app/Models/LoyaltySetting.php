<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LoyaltySetting extends Model
{
    protected $fillable = [
        'name',
        'points_required',
        'points_per_appointment',
        'is_active',
        'loyalty_rules'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'loyalty_rules' => 'array'
    ];

    public static function getActiveSettings()
    {
        $settings = self::where('is_active', true)->first();
        \Log::info('Retrieved loyalty settings', [
            'settings' => $settings ? [
                'id' => $settings->id,
                'points_per_appointment' => $settings->points_per_appointment,
                'is_active' => $settings->is_active,
                'loyalty_rules' => $settings->loyalty_rules
            ] : null
        ]);
        return $settings;
    }
}