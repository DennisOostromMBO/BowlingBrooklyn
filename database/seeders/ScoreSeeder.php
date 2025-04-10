<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ScoreSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('scores')->insert([
            ['reservation_id' => 1, 'points' => 150, 'round' => 1, 'isactive' => true, 'note' => 'Great game', 'created_at' => now(), 'updated_at' => now()],
            ['reservation_id' => 2, 'points' => 180, 'round' => 1, 'isactive' => true, 'note' => 'Personal best', 'created_at' => now(), 'updated_at' => now()],
            ['reservation_id' => 3, 'points' => 120, 'round' => 1, 'isactive' => true, 'note' => null, 'created_at' => now(), 'updated_at' => now()],
            ['reservation_id' => 4, 'points' => 200, 'round' => 1, 'isactive' => true, 'note' => 'Perfect game!', 'created_at' => now(), 'updated_at' => now()],
            ['reservation_id' => 5, 'points' => 165, 'round' => 1, 'isactive' => true, 'note' => null, 'created_at' => now(), 'updated_at' => now()],
            ['reservation_id' => 6, 'points' => 145, 'round' => 1, 'isactive' => true, 'note' => null, 'created_at' => now(), 'updated_at' => now()],
            ['reservation_id' => 7, 'points' => 190, 'round' => 1, 'isactive' => true, 'note' => 'Almost perfect', 'created_at' => now(), 'updated_at' => now()],
            ['reservation_id' => 8, 'points' => 130, 'round' => 1, 'isactive' => true, 'note' => null, 'created_at' => now(), 'updated_at' => now()],
            ['reservation_id' => 9, 'points' => 175, 'round' => 1, 'isactive' => true, 'note' => 'Great form', 'created_at' => now(), 'updated_at' => now()],
            ['reservation_id' => 10, 'points' => 110, 'round' => 1, 'isactive' => true, 'note' => 'Kids game', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
