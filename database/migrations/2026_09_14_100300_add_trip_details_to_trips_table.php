<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('trips', function (Blueprint $table) {
            $table->json('amenities')->nullable()->after('arrives_at');
            $table->json('exterior_photos')->nullable()->after('amenities');
            $table->json('interior_photos')->nullable()->after('exterior_photos');
            $table->json('facility_photos')->nullable()->after('interior_photos');
            $table->string('origin_address')->nullable()->after('facility_photos');
            $table->string('destination_address')->nullable()->after('origin_address');
            $table->string('rest_stop_name')->nullable()->after('destination_address');
            $table->string('rest_stop_address')->nullable()->after('rest_stop_name');
            $table->text('policy')->nullable()->after('rest_stop_address');
        });
    }

    public function down(): void
    {
        Schema::table('trips', function (Blueprint $table) {
            $table->dropColumn([
                'amenities', 'exterior_photos', 'interior_photos', 'facility_photos',
                'origin_address', 'destination_address', 'rest_stop_name', 'rest_stop_address', 'policy',
            ]);
        });
    }
};
