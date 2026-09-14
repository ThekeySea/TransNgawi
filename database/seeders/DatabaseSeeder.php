<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Dummy Admin
        User::firstOrCreate(
            ['email' => 'admin@transngawi.com'],
            [
                'name' => 'Administrator TransNgawi',
                'password' => bcrypt('password'),
                'role' => 'admin',
            ]
        );

        // Dummy User
        User::firstOrCreate(
            ['email' => 'user@transngawi.com'],
            [
                'name' => 'Pelanggan TransNgawi',
                'password' => bcrypt('password'),
                'role' => 'user',
            ]
        );

        $this->call(TripSeeder::class);
    }
}
