<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('persons', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('infix')->nullable();
            $table->string('last_name');

            if (DB::getDriverName() === 'mysql') {
                $table->string('full_name')->storedAs("CONCAT(first_name, ' ', IFNULL(infix, ''), ' ', last_name)");
            } else {
                $table->string('full_name'); // Fallback for SQLite
            }

            $table->date('date_of_birth');
            $table->boolean('is_active');
            $table->text('note')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('persons');
    }
};
