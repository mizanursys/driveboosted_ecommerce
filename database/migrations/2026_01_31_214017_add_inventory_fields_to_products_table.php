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
        Schema::table('products', function (Blueprint $table) {
            $table->string('sku')->unique()->after('slug')->nullable();
            $table->decimal('cost_price', 15, 2)->default(0)->after('price');
            $table->integer('stock_quantity')->default(0)->after('cost_price');
            $table->integer('low_stock_threshold')->default(10)->after('stock_quantity');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['sku', 'cost_price', 'stock_quantity', 'low_stock_threshold']);
        });
    }
};
