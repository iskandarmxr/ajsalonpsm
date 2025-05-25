<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('loyalty_settings', function (Blueprint $table) {
            $table->id();
            $table->integer('points_required');
            $table->integer('points_per_appointment');
            $table->boolean('is_active')->default(true);
            $table->json('loyalty_rules')->nullable(); // Added for storing rules
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('loyalty_settings');
    }
};