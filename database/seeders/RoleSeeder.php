<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('roles')->insert([
            ['name' => 'Admin', 'isactive' => true, 'note' => 'Full system access', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Manager', 'isactive' => true, 'note' => 'Bowling alley management', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Employee', 'isactive' => true, 'note' => 'Regular staff', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Customer', 'isactive' => true, 'note' => 'Regular customer', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'VIP Customer', 'isactive' => true, 'note' => 'Premium customer', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Maintenance', 'isactive' => true, 'note' => 'Technical staff', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Receptionist', 'isactive' => true, 'note' => 'Front desk staff', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Bar Staff', 'isactive' => true, 'note' => 'Bar and restaurant', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Trainer', 'isactive' => true, 'note' => 'Bowling instructor', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Guest', 'isactive' => true, 'note' => 'Limited access', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
