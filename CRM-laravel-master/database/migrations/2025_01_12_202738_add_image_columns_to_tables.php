<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // For services
        Schema::table('services', function (Blueprint $table) {
            $table->longText('image_data')->nullable();
            $table->string('image_type')->nullable();
        });

        // For company logo
        Schema::create('site_settings', function (Blueprint $table) {
            $table->id();
            $table->string('key');
            $table->longText('value');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::table('services', function (Blueprint $table) {
            $table->dropColumn(['image_data', 'image_type']);
        });

        Schema::dropIfExists('site_settings');
    }
};