<?php

namespace Database\Seeders;

use App\Models\LoyaltySetting;
use Illuminate\Database\Seeder;

class LoyaltySettingsSeeder extends Seeder
{
    public function run()
    {
        LoyaltySetting::create([
            'points_required' => 100,
            'points_per_appointment' => 10,
            'is_active' => true
        ]);
    }
}