<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrderSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('orders')->insert([
            ['bowling_alleyid' => 1, 'product' => 'Pizza', 'price' => 12.99, 'total_price' => 12.99, 'status' => 'send', 'isactive' => true, 'note' => null, 'created_at' => now(), 'updated_at' => now()],
            ['bowling_alleyid' => 2, 'product' => 'Nachos', 'price' => 8.99, 'total_price' => 8.99, 'status' => 'making', 'isactive' => true, 'note' => 'Extra cheese', 'created_at' => now(), 'updated_at' => now()],
            ['bowling_alleyid' => 3, 'product' => 'Drinks Package', 'price' => 24.99, 'total_price' => 24.99, 'status' => 'send', 'isactive' => true, 'note' => 'Birthday special', 'created_at' => now(), 'updated_at' => now()],
            ['bowling_alleyid' => 4, 'product' => 'Burger', 'price' => 14.99, 'total_price' => 14.99, 'status' => 'making', 'isactive' => true, 'note' => null, 'created_at' => now(), 'updated_at' => now()],
            ['bowling_alleyid' => 5, 'product' => 'VIP Package', 'price' => 49.99, 'total_price' => 99.98, 'status' => 'send', 'isactive' => true, 'note' => 'Include snacks', 'created_at' => now(), 'updated_at' => now()],
            ['bowling_alleyid' => 6, 'product' => 'Wings ', 'price' => 16.99, 'total_price' => 16.99, 'status' => 'making', 'isactive' => true, 'note' => 'Spicy', 'created_at' => now(), 'updated_at' => now()],
            ['bowling_alleyid' => 7, 'product' => 'Fries', 'price' => 6.99, 'total_price' => 6.99, 'status' => 'send', 'isactive' => true, 'note' => null, 'created_at' => now(), 'updated_at' => now()],
            ['bowling_alleyid' => 8, 'product' => 'Snack Platter', 'price' => 19.99, 'total_price' => 19.99, 'status' => 'making', 'isactive' => true, 'note' => 'Team size', 'created_at' => now(), 'updated_at' => now()],
            ['bowling_alleyid' => 9, 'product' => 'Premium Drinks', 'price' => 34.99, 'total_price' => 34.99, 'status' => 'send', 'isactive' => true, 'note' => 'VIP service', 'created_at' => now(), 'updated_at' => now()],
            ['bowling_alleyid' => 10, 'product' => 'Kids Menu', 'price' => 9.99, 'total_price' => 9.99, 'status' => 'making', 'isactive' => true, 'note' => 'No allergens', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
