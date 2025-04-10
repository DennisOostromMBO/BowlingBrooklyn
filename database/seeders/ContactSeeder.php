<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ContactSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('contacts')->insert([
            [
                'customer_id' => 1,
                'street_name' => 'Hoofdstraat',
                'house_number' => '123',
                'addition' => 'A',
                'postal_code' => '1234AB',
                'city' => 'Amsterdam',
                'is_active' => true,
                'note' => 'Hoofdingang gebruiken',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'customer_id' => 2,
                'street_name' => 'Kerkstraat',
                'house_number' => '45',
                'addition' => null,
                'postal_code' => '2345BC',
                'city' => 'Rotterdam',
                'is_active' => true,
                'note' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'customer_id' => 3,
                'street_name' => 'Dorpsweg',
                'house_number' => '78',
                'addition' => 'B',
                'postal_code' => '3456CD',
                'city' => 'Utrecht',
                'is_active' => true,
                'note' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'customer_id' => 4,
                'street_name' => 'Stationsplein',
                'house_number' => '12',
                'addition' => null,
                'postal_code' => '4567DE',
                'city' => 'Den Haag',
                'is_active' => true,
                'note' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'customer_id' => 5,
                'street_name' => 'Marktstraat',
                'house_number' => '34',
                'addition' => 'C',
                'postal_code' => '5678EF',
                'city' => 'Eindhoven',
                'is_active' => true,
                'note' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'customer_id' => 6,
                'street_name' => 'Schoolweg',
                'house_number' => '56',
                'addition' => null,
                'postal_code' => '6789FG',
                'city' => 'Groningen',
                'is_active' => true,
                'note' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'customer_id' => 7,
                'street_name' => 'Parkweg',
                'house_number' => '89',
                'addition' => 'D',
                'postal_code' => '7890GH',
                'city' => 'Tilburg',
                'is_active' => true,
                'note' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'customer_id' => 8,
                'street_name' => 'Zeeweg',
                'house_number' => '101',
                'addition' => null,
                'postal_code' => '8901HJ',
                'city' => 'Almere',
                'is_active' => true,
                'note' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'customer_id' => 9,
                'street_name' => 'Molenstraat',
                'house_number' => '23',
                'addition' => 'E',
                'postal_code' => '9012JK',
                'city' => 'Breda',
                'is_active' => true,
                'note' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'customer_id' => 10,
                'street_name' => 'Dijkweg',
                'house_number' => '45',
                'addition' => null,
                'postal_code' => '1122KL',
                'city' => 'Nijmegen',
                'is_active' => true,
                'note' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}