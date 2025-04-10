<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ScoreSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('scores')->insert([
            [
                'reservation_id' => 1, 'points' => 150, 'round' => 1, 'isactive' => true, 'note' => 'Great game', 'status' => 'In progress',
                'team_name' => 'The Strikers',
                'teammate1' => 'Alice', 'teammate1_score' => 50,
                'teammate2' => 'Bob', 'teammate2_score' => 100,
                'teammate3' => null, 'teammate3_score' => null,
                'teammate4' => null, 'teammate4_score' => null,
                'teammate5' => null, 'teammate5_score' => null,
                'teammate6' => null, 'teammate6_score' => null,
                'teammate7' => null, 'teammate7_score' => null,
                'teammate8' => null, 'teammate8_score' => null,
                'created_at' => now(), 'updated_at' => now()
            ],
            [
                'reservation_id' => 2, 'points' => 180, 'round' => 1, 'isactive' => true, 'note' => 'Personal best', 'status' => 'Confirmed',
                'team_name' => 'Perfect Pins',
                'teammate1' => 'Charlie', 'teammate1_score' => 90,
                'teammate2' => 'David', 'teammate2_score' => 90,
                'teammate3' => null, 'teammate3_score' => null,
                'teammate4' => null, 'teammate4_score' => null,
                'teammate5' => null, 'teammate5_score' => null,
                'teammate6' => null, 'teammate6_score' => null,
                'teammate7' => null, 'teammate7_score' => null,
                'teammate8' => null, 'teammate8_score' => null,
                'created_at' => now(), 'updated_at' => now()
            ],
            [
                'reservation_id' => 3, 'points' => 120, 'round' => 1, 'isactive' => true, 'note' => null, 'status' => 'In progress',
                'team_name' => 'Gutter Gang',
                'teammate1' => 'Eve', 'teammate1_score' => 60,
                'teammate2' => 'Frank', 'teammate2_score' => 60,
                'teammate3' => null, 'teammate3_score' => null,
                'teammate4' => null, 'teammate4_score' => null,
                'teammate5' => null, 'teammate5_score' => null,
                'teammate6' => null, 'teammate6_score' => null,
                'teammate7' => null, 'teammate7_score' => null,
                'teammate8' => null, 'teammate8_score' => null,
                'created_at' => now(), 'updated_at' => now()
            ],
            [
                'reservation_id' => 4, 'points' => 200, 'round' => 1, 'isactive' => true, 'note' => 'Perfect game!', 'status' => 'Confirmed',
                'team_name' => 'Alley Cats',
                'teammate1' => 'Grace', 'teammate1_score' => 100,
                'teammate2' => 'Heidi', 'teammate2_score' => 100,
                'teammate3' => null, 'teammate3_score' => null,
                'teammate4' => null, 'teammate4_score' => null,
                'teammate5' => null, 'teammate5_score' => null,
                'teammate6' => null, 'teammate6_score' => null,
                'teammate7' => null, 'teammate7_score' => null,
                'teammate8' => null, 'teammate8_score' => null,
                'created_at' => now(), 'updated_at' => now()
            ],
            [
                'reservation_id' => 5, 'points' => 165, 'round' => 1, 'isactive' => true, 'note' => null, 'status' => 'In progress',
                'team_name' => 'Pin Pals',
                'teammate1' => 'Ivan', 'teammate1_score' => 80,
                'teammate2' => 'Judy', 'teammate2_score' => 85,
                'teammate3' => null, 'teammate3_score' => null,
                'teammate4' => null, 'teammate4_score' => null,
                'teammate5' => null, 'teammate5_score' => null,
                'teammate6' => null, 'teammate6_score' => null,
                'teammate7' => null, 'teammate7_score' => null,
                'teammate8' => null, 'teammate8_score' => null,
                'created_at' => now(), 'updated_at' => now()
            ],
            [
                'reservation_id' => 6, 'points' => 145, 'round' => 1, 'isactive' => true, 'note' => null, 'status' => 'In progress',
                'team_name' => 'Lane Sharks',
                'teammate1' => 'Karl', 'teammate1_score' => 70,
                'teammate2' => 'Liam', 'teammate2_score' => 75,
                'teammate3' => null, 'teammate3_score' => null,
                'teammate4' => null, 'teammate4_score' => null,
                'teammate5' => null, 'teammate5_score' => null,
                'teammate6' => null, 'teammate6_score' => null,
                'teammate7' => null, 'teammate7_score' => null,
                'teammate8' => null, 'teammate8_score' => null,
                'created_at' => now(), 'updated_at' => now()
            ],
            [
                'reservation_id' => 7, 'points' => 190, 'round' => 1, 'isactive' => true, 'note' => 'Almost perfect', 'status' => 'Confirmed',
                'team_name' => 'Split Happens',
                'teammate1' => 'Mallory', 'teammate1_score' => 95,
                'teammate2' => 'Niaj', 'teammate2_score' => 95,
                'teammate3' => null, 'teammate3_score' => null,
                'teammate4' => null, 'teammate4_score' => null,
                'teammate5' => null, 'teammate5_score' => null,
                'teammate6' => null, 'teammate6_score' => null,
                'teammate7' => null, 'teammate7_score' => null,
                'teammate8' => null, 'teammate8_score' => null,
                'created_at' => now(), 'updated_at' => now()
            ],
            [
                'reservation_id' => 8, 'points' => 130, 'round' => 1, 'isactive' => true, 'note' => null, 'status' => 'In progress',
                'team_name' => 'Strike Force',
                'teammate1' => 'Olivia', 'teammate1_score' => 65,
                'teammate2' => 'Peggy', 'teammate2_score' => 65,
                'teammate3' => null, 'teammate3_score' => null,
                'teammate4' => null, 'teammate4_score' => null,
                'teammate5' => null, 'teammate5_score' => null,
                'teammate6' => null, 'teammate6_score' => null,
                'teammate7' => null, 'teammate7_score' => null,
                'teammate8' => null, 'teammate8_score' => null,
                'created_at' => now(), 'updated_at' => now()
            ],
            [
                'reservation_id' => 9, 'points' => 175, 'round' => 1, 'isactive' => true, 'note' => 'Great form', 'status' => 'Confirmed',
                'team_name' => 'Bowl Stars',
                'teammate1' => 'Quentin', 'teammate1_score' => 85,
                'teammate2' => 'Ruth', 'teammate2_score' => 90,
                'teammate3' => null, 'teammate3_score' => null,
                'teammate4' => null, 'teammate4_score' => null,
                'teammate5' => null, 'teammate5_score' => null,
                'teammate6' => null, 'teammate6_score' => null,
                'teammate7' => null, 'teammate7_score' => null,
                'teammate8' => null, 'teammate8_score' => null,
                'created_at' => now(), 'updated_at' => now()
            ],
            [
                'reservation_id' => 10, 'points' => 110, 'round' => 1, 'isactive' => true, 'note' => 'Kids game', 'status' => 'In progress',
                'team_name' => 'Tiny Bowlers',
                'teammate1' => 'Steve', 'teammate1_score' => 55,
                'teammate2' => 'Trent', 'teammate2_score' => 55,
                'teammate3' => null, 'teammate3_score' => null,
                'teammate4' => null, 'teammate4_score' => null,
                'teammate5' => null, 'teammate5_score' => null,
                'teammate6' => null, 'teammate6_score' => null,
                'teammate7' => null, 'teammate7_score' => null,
                'teammate8' => null, 'teammate8_score' => null,
                'created_at' => now(), 'updated_at' => now()
            ],
        ]);
    }
}
