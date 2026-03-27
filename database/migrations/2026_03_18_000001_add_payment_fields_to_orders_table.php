<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->string('square_order_id')->nullable()->after('address_id');
            $table->string('square_payment_id')->nullable()->after('square_order_id');
            $table->enum('payment_status', ['pending', 'paid', 'failed'])->default('pending')->after('square_payment_id');
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['square_order_id', 'square_payment_id', 'payment_status']);
        });
    }
};
