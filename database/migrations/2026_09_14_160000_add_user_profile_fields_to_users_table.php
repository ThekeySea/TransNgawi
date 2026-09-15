<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $hasUsername = Schema::hasColumn('users', 'username');
        $hasPhone = Schema::hasColumn('users', 'phone_number');
        $hasPhoto = Schema::hasColumn('users', 'profile_photo_path');

        Schema::table('users', function (Blueprint $table) use ($hasUsername, $hasPhone, $hasPhoto) {
            if (! $hasUsername) {
                $table->string('username')->after('name');
            }
            if (! $hasPhone) {
                $table->string('phone_number')->after('username')->default('');
            }
            if (! $hasPhoto) {
                $table->string('profile_photo_path')->nullable()->after('phone_number');
            }
        });

        // Generate default usernames for existing users with empty usernames
        DB::table('users')
            ->where('username', '')
            ->orWhereNull('username')
            ->orderBy('id')
            ->each(function ($user) {
                $base = strtolower(preg_replace('/[^a-zA-Z0-9]/', '', $user->name));
                if (empty($base)) {
                    $base = 'user';
                }
                $username = $base;
                $counter = 1;
                while (DB::table('users')->where('username', $username)->where('id', '!=', $user->id)->exists()) {
                    $username = $base . $counter;
                    $counter++;
                }
                DB::table('users')->where('id', $user->id)->update(['username' => $username]);
            });

        // Add unique constraint if not already present
        $hasUnique = collect(Schema::getIndexes('users'))->contains('name', 'users_username_unique');
        if (! $hasUnique) {
            Schema::table('users', function (Blueprint $table) {
                $table->unique('username');
            });
        }
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['username', 'phone_number', 'profile_photo_path']);
        });
    }
};
