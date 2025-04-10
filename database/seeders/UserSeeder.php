<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('users')->insert([
            ['person_id' => 1, 'roll_id' => 1, 'name' => 'John Doe', 'email' => 'john@example.com', 'phone' => '0612345671', 'password' => Hash::make('password123'), 'created_at' => now(), 'updated_at' => now()],
            ['person_id' => 2, 'roll_id' => 2, 'name' => 'Jane Smith', 'email' => 'jane@example.com', 'phone' => '0612345672', 'password' => Hash::make('password123'), 'created_at' => now(), 'updated_at' => now()],
            ['person_id' => 3, 'roll_id' => 3, 'name' => 'Mike Johnson', 'email' => 'mike@example.com', 'phone' => '0612345673', 'password' => Hash::make('password123'), 'created_at' => now(), 'updated_at' => now()],
            ['person_id' => 4, 'roll_id' => 4, 'name' => 'Lisa Brown', 'email' => 'lisa@example.com', 'phone' => '0612345674', 'password' => Hash::make('password123'), 'created_at' => now(), 'updated_at' => now()],
            ['person_id' => 5, 'roll_id' => 5, 'name' => 'David Wilson', 'email' => 'david@example.com', 'phone' => '0612345675', 'password' => Hash::make('password123'), 'created_at' => now(), 'updated_at' => now()],
            ['person_id' => 6, 'roll_id' => 6, 'name' => 'Sarah Taylor', 'email' => 'sarah@example.com', 'phone' => '0612345676', 'password' => Hash::make('password123'), 'created_at' => now(), 'updated_at' => now()],
            ['person_id' => 7, 'roll_id' => 7, 'name' => 'Tom Anderson', 'email' => 'tom@example.com', 'phone' => '0612345677', 'password' => Hash::make('password123'), 'created_at' => now(), 'updated_at' => now()],
            ['person_id' => 8, 'roll_id' => 8, 'name' => 'Emma Martinez', 'email' => 'emma@example.com', 'phone' => '0612345678', 'password' => Hash::make('password123'), 'created_at' => now(), 'updated_at' => now()],
            ['person_id' => 9, 'roll_id' => 9, 'name' => 'James Thomas', 'email' => 'james@example.com', 'phone' => '0612345679', 'password' => Hash::make('password123'), 'created_at' => now(), 'updated_at' => now()],
            ['person_id' => 10, 'roll_id' => 10, 'name' => 'Laura Garcia', 'email' => 'laura@example.com', 'phone' => '0612345680', 'password' => Hash::make('password123'), 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
