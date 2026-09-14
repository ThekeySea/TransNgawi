<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('trips', function (Blueprint $table) {
            $table->string('trip_code', 24)->nullable();
        });

        // Backfill existing trips that have empty or null trip_code
        $trips = DB::table('trips')->where(function ($q) {
            $q->whereNull('trip_code')->orWhere('trip_code', '');
        })->get();

        foreach ($trips as $trip) {
            $date = \Carbon\Carbon::parse($trip->created_at);
            do {
                $code = 'TRIP-' . $date->format('Ymd') . '-' . strtoupper(bin2hex(random_bytes(2)));
            } while (DB::table('trips')->where('trip_code', $code)->exists());

            DB::table('trips')->where('id', $trip->id)->update(['trip_code' => $code]);
        }

        // Now make it NOT NULL and add unique constraint
        Schema::table('trips', function (Blueprint $table) {
            $table->string('trip_code', 24)->nullable(false)->unique()->change();
        });
    }

    public function down(): void
    {
        Schema::table('trips', function (Blueprint $table) {
            $table->dropIndex('trips_trip_code_unique');
            $table->dropColumn('trip_code');
        });
    }
};
