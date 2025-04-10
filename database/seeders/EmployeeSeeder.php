<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EmployeeSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('employees')->insert([
            ['user_id' => 1, 'number' => 'EMP001', 'is_active' => true, 'note' => 'Manager', 'created_at' => now(), 'updated_at' => now()],
            ['user_id' => 2, 'number' => 'EMP002', 'is_active' => true, 'note' => 'Front Desk', 'created_at' => now(), 'updated_at' => now()],
            ['user_id' => 3, 'number' => 'EMP003', 'is_active' => true, 'note' => 'Bar Staff', 'created_at' => now(), 'updated_at' => now()],
            ['user_id' => 4, 'number' => 'EMP004', 'is_active' => true, 'note' => 'Maintenance', 'created_at' => now(), 'updated_at' => now()],
            ['user_id' => 5, 'number' => 'EMP005', 'is_active' => true, 'note' => 'Instructor', 'created_at' => now(), 'updated_at' => now()],
            ['user_id' => 6, 'number' => 'EMP006', 'is_active' => true, 'note' => 'Cleaner', 'created_at' => now(), 'updated_at' => now()],
            ['user_id' => 7, 'number' => 'EMP007', 'is_active' => true, 'note' => 'Security', 'created_at' => now(), 'updated_at' => now()],
            ['user_id' => 8, 'number' => 'EMP008', 'is_active' => true, 'note' => 'Bar Staff', 'created_at' => now(), 'updated_at' => now()],
            ['user_id' => 9, 'number' => 'EMP009', 'is_active' => true, 'note' => 'Front Desk', 'created_at' => now(), 'updated_at' => now()],
            ['user_id' => 10, 'number' => 'EMP010', 'is_active' => true, 'note' => 'Maintenance', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
