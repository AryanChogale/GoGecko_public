<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // remove from users
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['state', 'city', 'sms_consent']);
        });

        // add to customer_profiles
        Schema::table('customer_profiles', function (Blueprint $table) {
            $table->string('state')->nullable();
            $table->string('city')->nullable();
            $table->boolean('sms_consent')->default(false);
        });
    }
};
