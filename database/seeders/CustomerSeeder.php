<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CustomerSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('customers')->insert([
            ['persons_id' => 1, 'customer_number' => 'BB001', 'is_active' => true, 'note' => 'Regular bowler', 'created_at' => now(), 'updated_at' => now()],
            ['persons_id' => 2, 'customer_number' => 'BB002', 'is_active' => true, 'note' => 'League player', 'created_at' => now(), 'updated_at' => now()],
            ['persons_id' => 3, 'customer_number' => 'BB003', 'is_active' => true, 'note' => 'Weekend visitor', 'created_at' => now(), 'updated_at' => now()],
            ['persons_id' => 4, 'customer_number' => 'BB004', 'is_active' => true, 'note' => 'VIP member', 'created_at' => now(), 'updated_at' => now()],
            ['persons_id' => 5, 'customer_number' => 'BB005', 'is_active' => true, 'note' => 'Family package', 'created_at' => now(), 'updated_at' => now()],
            ['persons_id' => 6, 'customer_number' => 'BB006', 'is_active' => true, 'note' => 'Student discount', 'created_at' => now(), 'updated_at' => now()],
            ['persons_id' => 7, 'customer_number' => 'BB007', 'is_active' => true, 'note' => 'Competition player', 'created_at' => now(), 'updated_at' => now()],
            ['persons_id' => 8, 'customer_number' => 'BB008', 'is_active' => true, 'note' => 'Birthday package', 'created_at' => now(), 'updated_at' => now()],
            ['persons_id' => 9, 'customer_number' => 'BB009', 'is_active' => true, 'note' => 'Corporate events', 'created_at' => now(), 'updated_at' => now()],
            ['persons_id' => 10, 'customer_number' => 'BB010', 'is_active' => true, 'note' => 'Senior member', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
