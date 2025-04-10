<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BowlingSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('bowling_alley')->insert([
            ['number' => 1, 'isactive' => true, 'note' => 'Standard lane', 'created_at' => now(), 'updated_at' => now()],
            ['number' => 2, 'isactive' => true, 'note' => 'Standard lane', 'created_at' => now(), 'updated_at' => now()],
            ['number' => 3, 'isactive' => true, 'note' => 'Kids lane', 'created_at' => now(), 'updated_at' => now()],
            ['number' => 4, 'isactive' => true, 'note' => 'Competition lane', 'created_at' => now(), 'updated_at' => now()],
            ['number' => 5, 'isactive' => true, 'note' => 'VIP lane', 'created_at' => now(), 'updated_at' => now()],
            ['number' => 6, 'isactive' => true, 'note' => 'Standard lane', 'created_at' => now(), 'updated_at' => now()],
            ['number' => 7, 'isactive' => true, 'note' => 'Standard lane', 'created_at' => now(), 'updated_at' => now()],
            ['number' => 8, 'isactive' => true, 'note' => 'Competition lane', 'created_at' => now(), 'updated_at' => now()],
            ['number' => 9, 'isactive' => true, 'note' => 'VIP lane', 'created_at' => now(), 'updated_at' => now()],
            ['number' => 10, 'isactive' => true, 'note' => 'Kids lane', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
