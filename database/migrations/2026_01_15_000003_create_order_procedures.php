<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Drop existing procedure if it exists
        DB::unprepared('DROP PROCEDURE IF EXISTS spGetAllOrders');

        // Create spGetAllOrders procedure
        $pathGetAllOrders = database_path('sp/OrdersSP/spGetAllOrders.sql');
        DB::unprepared(File::get($pathGetAllOrders));
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Drop the procedure
        DB::unprepared('DROP PROCEDURE IF EXISTS spGetAllOrders');
    }
};