<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ReservationSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('reservations')->insert([
            ['user_id' => 1, 'ally_number' => 1, 'number_of_persons' => 4, 'isactive' => true, 'note' => 'Family booking', 'created_at' => now(), 'updated_at' => now()],
            ['user_id' => 2, 'ally_number' => 2, 'number_of_persons' => 2, 'isactive' => true, 'note' => 'Date night', 'created_at' => now(), 'updated_at' => now()],
            ['user_id' => 3, 'ally_number' => 3, 'number_of_persons' => 6, 'isactive' => true, 'note' => 'Birthday party', 'created_at' => now(), 'updated_at' => now()],
            ['user_id' => 4, 'ally_number' => 4, 'number_of_persons' => 3, 'isactive' => true, 'note' => null, 'created_at' => now(), 'updated_at' => now()],
            ['user_id' => 5, 'ally_number' => 5, 'number_of_persons' => 5, 'isactive' => true, 'note' => 'Corporate event', 'created_at' => now(), 'updated_at' => now()],
            ['user_id' => 6, 'ally_number' => 6, 'number_of_persons' => 4, 'isactive' => true, 'note' => null, 'created_at' => now(), 'updated_at' => now()],
            ['user_id' => 7, 'ally_number' => 7, 'number_of_persons' => 2, 'isactive' => true, 'note' => 'Practice session', 'created_at' => now(), 'updated_at' => now()],
            ['user_id' => 8, 'ally_number' => 8, 'number_of_persons' => 8, 'isactive' => true, 'note' => 'Team building', 'created_at' => now(), 'updated_at' => now()],
            ['user_id' => 9, 'ally_number' => 9, 'number_of_persons' => 4, 'isactive' => true, 'note' => null, 'created_at' => now(), 'updated_at' => now()],
            ['user_id' => 10, 'ally_number' => 10, 'number_of_persons' => 6, 'isactive' => true, 'note' => 'Kids party', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
