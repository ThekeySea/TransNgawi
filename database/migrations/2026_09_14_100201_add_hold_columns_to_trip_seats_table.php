<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('trip_seats', function (Blueprint $table) {
            $table->timestamp('hold_expires_at')->nullable()->after('status');
            $table->unsignedBigInteger('held_by_booking_id')->nullable()->after('hold_expires_at');
        });
    }

    public function down(): void
    {
        Schema::table('trip_seats', function (Blueprint $table) {
            $table->dropColumn(['hold_expires_at', 'held_by_booking_id']);
        });
    }
};
