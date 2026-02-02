<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('appointments', function (Blueprint $table) {
            $table->string('vehicle_make')->nullable()->after('customer_phone');
            $table->string('vehicle_type')->nullable()->after('vehicle_model');
            $table->string('licence_plate')->nullable()->after('vehicle_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('appointments', function (Blueprint $table) {
            $table->dropColumn(['vehicle_make', 'vehicle_type', 'licence_plate']);
        });
    }
};
