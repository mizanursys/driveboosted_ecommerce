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
            $table->index('customer_name');
            $table->index('customer_phone');
            $table->index('appointment_date');
        });

        Schema::table('products', function (Blueprint $table) {
            $table->index('name');
            $table->index('sku');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('appointments', function (Blueprint $table) {
            $table->dropIndex(['customer_name']);
            $table->dropIndex(['customer_phone']);
            $table->dropIndex(['appointment_date']);
        });

        Schema::table('products', function (Blueprint $table) {
            $table->dropIndex(['name']);
            $table->dropIndex(['sku']);
        });
    }
};
