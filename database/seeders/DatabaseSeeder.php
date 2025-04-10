<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Call the custom seeders
        $this->call([
            RoleSeeder::class,
            UserSeeder::class,
            PersonSeeder::class,
            EmployeeSeeder::class,
            CustomerSeeder::class,
            ContactSeeder::class,
            BowlingSeeder::class,
            ReservationSeeder::class,
            OrderSeeder::class,
            ScoreSeeder::class,
        ]);

    }
}
