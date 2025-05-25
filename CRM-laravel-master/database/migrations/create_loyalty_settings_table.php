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
            $table->string('name');
            $table->integer('points_required');
            $table->decimal('discount_percentage', 5, 2);
            $table->integer('points_per_appointment');
            $table->integer('minimum_spend')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('loyalty_settings');
    }
};