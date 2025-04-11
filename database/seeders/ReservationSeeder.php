<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ReservationSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('reservations')->insert([
            // Past dates for unhappy scenarios
            ['user_id' => 1, 'ally_number' => 1, 'number_of_persons' => 4, 'reservation_date' => '2025-03-01', 'isactive' => true, 'note' => 'Expired booking', 'created_at' => now(), 'updated_at' => now()],
            ['user_id' => 2, 'ally_number' => 2, 'number_of_persons' => 2, 'reservation_date' => '2025-03-15', 'isactive' => true, 'note' => 'Old reservation', 'created_at' => now(), 'updated_at' => now()],
            ['user_id' => 3, 'ally_number' => 3, 'number_of_persons' => 6, 'reservation_date' => '2025-03-20', 'isactive' => true, 'note' => 'Missed event', 'created_at' => now(), 'updated_at' => now()],

            // Future dates for happy scenarios
            ['user_id' => 4, 'ally_number' => 4, 'number_of_persons' => 3, 'reservation_date' => '2025-04-18', 'isactive' => true, 'note' => null, 'created_at' => now(), 'updated_at' => now()],
            ['user_id' => 5, 'ally_number' => 5, 'number_of_persons' => 5, 'reservation_date' => '2025-04-19', 'isactive' => true, 'note' => 'Corporate event', 'created_at' => now(), 'updated_at' => now()],
            ['user_id' => 6, 'ally_number' => 6, 'number_of_persons' => 4, 'reservation_date' => '2025-04-20', 'isactive' => true, 'note' => null, 'created_at' => now(), 'updated_at' => now()],
            ['user_id' => 7, 'ally_number' => 7, 'number_of_persons' => 2, 'reservation_date' => '2025-04-21', 'isactive' => true, 'note' => 'Practice session', 'created_at' => now(), 'updated_at' => now()],
            ['user_id' => 8, 'ally_number' => 8, 'number_of_persons' => 8, 'reservation_date' => '2025-04-22', 'isactive' => true, 'note' => 'Team building', 'created_at' => now(), 'updated_at' => now()],
            ['user_id' => 9, 'ally_number' => 9, 'number_of_persons' => 4, 'reservation_date' => '2025-04-23', 'isactive' => true, 'note' => null, 'created_at' => now(), 'updated_at' => now()],
            ['user_id' => 10, 'ally_number' => 10, 'number_of_persons' => 6, 'reservation_date' => '2025-04-24', 'isactive' => true, 'note' => 'Kids party', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
