<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PersonSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('persons')->insert([
            ['first_name' => 'John', 'infix' => 'van', 'last_name' => 'Doe', 'date_of_birth' => '1990-01-15', 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['first_name' => 'Jane', 'infix' => null, 'last_name' => 'Smith', 'date_of_birth' => '1992-03-20', 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['first_name' => 'Mike', 'infix' => 'de', 'last_name' => 'Johnson', 'date_of_birth' => '1985-07-10', 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['first_name' => 'Lisa', 'infix' => null, 'last_name' => 'Brown', 'date_of_birth' => '1988-11-30', 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['first_name' => 'David', 'infix' => 'van der', 'last_name' => 'Wilson', 'date_of_birth' => '1995-05-25', 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['first_name' => 'Sarah', 'infix' => null, 'last_name' => 'Taylor', 'date_of_birth' => '1993-09-12', 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['first_name' => 'Tom', 'infix' => 'van', 'last_name' => 'Anderson', 'date_of_birth' => '1987-12-05', 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['first_name' => 'Emma', 'infix' => null, 'last_name' => 'Martinez', 'date_of_birth' => '1991-04-18', 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['first_name' => 'James', 'infix' => 'de', 'last_name' => 'Thomas', 'date_of_birth' => '1986-08-22', 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['first_name' => 'Laura', 'infix' => null, 'last_name' => 'Garcia', 'date_of_birth' => '1994-02-28', 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
