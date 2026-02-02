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
        Schema::table('orders', function (Blueprint $table) {
            $table->enum('order_type', ['online', 'pos'])->default('online')->after('order_number');
            $table->foreignId('pos_session_id')->nullable()->after('order_type')->constrained('pos_sessions')->onDelete('set null');
            $table->decimal('discount_amount', 15, 2)->default(0)->after('shipping');
            $table->enum('discount_type', ['fixed', 'percentage'])->default('fixed')->after('discount_amount');
            $table->decimal('paid_amount', 15, 2)->default(0)->after('total');
            $table->decimal('change_amount', 15, 2)->default(0)->after('paid_amount');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropForeign(['pos_session_id']);
            $table->dropColumn(['order_type', 'pos_session_id', 'discount_amount', 'discount_type', 'paid_amount', 'change_amount']);
        });
    }
};
