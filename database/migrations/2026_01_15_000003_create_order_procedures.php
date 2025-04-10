<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;

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
        if (File::exists($pathGetAllOrders)) {
            DB::unprepared(File::get($pathGetAllOrders));
        } else {
            Log::warning("File not found: $pathGetAllOrders");
        }
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