<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('trips', function (Blueprint $table) {
            $table->foreignId('origin_stop_point_id')->nullable()->after('bus_id')->constrained('stop_points')->nullOnDelete();
            $table->foreignId('destination_stop_point_id')->nullable()->after('origin_stop_point_id')->constrained('stop_points')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('trips', function (Blueprint $table) {
            $table->dropForeign(['origin_stop_point_id']);
            $table->dropForeign(['destination_stop_point_id']);
            $table->dropColumn(['origin_stop_point_id', 'destination_stop_point_id']);
        });
    }
};
