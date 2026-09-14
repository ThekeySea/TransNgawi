<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('booking_seats', function (Blueprint $table) {
            $table->id();
            $table->foreignId('booking_id')->constrained()->cascadeOnDelete();
            $table->foreignId('trip_seat_id')->constrained()->cascadeOnDelete();
            $table->string('seat_code', 8);
            $table->string('class_name', 32);
            $table->unsignedInteger('fare_amount');
            $table->timestamps();

            $table->unique(['booking_id', 'trip_seat_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('booking_seats');
    }
};
