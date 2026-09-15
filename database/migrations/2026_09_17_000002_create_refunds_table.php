<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('refunds', function (Blueprint $table) {
            $table->id();
            $table->foreignId('booking_id')->constrained()->cascadeOnDelete();
            $table->foreignId('trip_id')->nullable()->constrained()->nullOnDelete();
            $table->unsignedInteger('refund_amount');
            $table->unsignedInteger('refund_percentage')->default(100);
            $table->string('reason')->nullable();
            $table->string('type', 32)->default('TRIP_CANCELLATION');
            $table->timestamps();

            $table->index(['trip_id', 'type']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('refunds');
    }
};
