<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('appointments', function (Blueprint $table) {
            // Drop the existing status column
            $table->dropColumn('status');
        });

        Schema::table('appointments', function (Blueprint $table) {
            // Create a new status column as string
            $table->enum('status', [
                'pending',
                'confirmed',
                'completed',
                'rejected',
                'cancelled'
            ])->default('pending');
        });
    }

    public function down()
    {
        Schema::table('appointments', function (Blueprint $table) {
            $table->dropColumn('status');
            $table->boolean('status')->default(true);
        });
    }
};