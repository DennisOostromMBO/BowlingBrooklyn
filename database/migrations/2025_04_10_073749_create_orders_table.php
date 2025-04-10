<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('bowling_alleyid');
            $table->enum('product', ['Pizza', 'Nachos', 'Drinks Package', 'Burger', 'VIP Package', 'Wings', 'Fries', 'Snack Platter', 'Premium Drinks', 'Kids Menu']);
            $table->enum('status', ['send', 'making', 'pending']);
            $table->decimal('price', 8, 2)->storedAs("CASE 
                WHEN product = 'Pizza' THEN 10.00
                WHEN product = 'Nachos' THEN 8.00
                WHEN product = 'Drinks Package' THEN 15.00
                WHEN product = 'Burger' THEN 12.00
                WHEN product = 'VIP Package' THEN 50.00
                WHEN product = 'Wings' THEN 9.00
                WHEN product = 'Fries' THEN 5.00
                WHEN product = 'Snack Platter' THEN 20.00
                WHEN product = 'Premium Drinks' THEN 25.00
                WHEN product = 'Kids Menu' THEN 7.00
                ELSE 0.00 END");
            $table->decimal('total_price', 10, 2)->default(0.00);
            $table->boolean('isactive')->default(true);
            $table->text('note')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
