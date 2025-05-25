<?php

namespace Database\Seeders;

use App\Models\LoyaltySetting;
use Illuminate\Database\Seeder;

class LoyaltySettingsSeeder extends Seeder
{
    public function run()
    {
        LoyaltySetting::create([
            'name' => 'Default Loyalty Program',
            'points_required' => 100,
            'discount_percentage' => 10.00,
            'points_per_appointment' => 10,
            'minimum_spend' => 1000,
            'is_active' => true
        ]);
    }
}