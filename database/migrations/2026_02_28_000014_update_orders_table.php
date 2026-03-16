<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            // Drop old status column and recreate with full enum
            $table->dropColumn('status');
        });

        Schema::table('orders', function (Blueprint $table) {
            $table->enum('status', ['pending', 'shipped', 'out_for_delivery', 'delivered'])
                ->default('pending')
                ->after('total_amount');

            // Link order to the address it was delivered to
            $table->foreignId('address_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete()
                ->after('branch_id');
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropForeign(['address_id']);
            $table->dropColumn(['address_id', 'status']);
        });

        Schema::table('orders', function (Blueprint $table) {
            $table->enum('status', ['pending', 'delivered'])->default('pending');
        });
    }
};
