<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->string('code', 16)->unique();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('trip_id')->constrained()->cascadeOnDelete();
            $table->string('status', 32)->default('PENDING');
            $table->string('passenger_name', 120);
            $table->string('passenger_email', 180);
            $table->string('passenger_phone', 32);
            $table->unsignedInteger('subtotal');
            $table->unsignedInteger('total');
            $table->timestamp('hold_expires_at');
            $table->timestamp('paid_at')->nullable();
            $table->timestamps();

            $table->index(['trip_id', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
