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
        DB::unprepared('DROP PROCEDURE IF EXISTS spDeleteOrder');
        DB::unprepared('DROP PROCEDURE IF EXISTS spUpdateOrder');
        DB::unprepared('DROP PROCEDURE IF EXISTS spCreateOrder');

        // Create spGetAllOrders procedure
        $pathGetAllOrders = database_path('sp/OrdersSP/spGetAllOrders.sql');
        if (File::exists($pathGetAllOrders)) {
            DB::unprepared(File::get($pathGetAllOrders));
        } else {
            Log::warning("File not found: $pathGetAllOrders");
        }

        // Create spDeleteOrder procedure
        $pathDeleteOrder = database_path('sp/OrdersSP/spDeleteOrder.sql');
        if (File::exists($pathDeleteOrder)) {
            DB::unprepared(File::get($pathDeleteOrder));
        } else {
            Log::warning("File not found: $pathDeleteOrder");
        }

        // Create spUpdateOrder procedure
        $pathUpdateOrder = database_path('sp/OrdersSP/spUpdateOrder.sql');
        if (File::exists($pathUpdateOrder)) {
            DB::unprepared(File::get($pathUpdateOrder));
        } else {
            Log::warning("File not found: $pathUpdateOrder");
        }

        // Create spCreateOrder procedure
        $pathCreateOrder = database_path('sp/OrdersSP/spCreateOrder.sql');
        if (File::exists($pathCreateOrder)) {
            DB::unprepared(File::get($pathCreateOrder));
        } else {
            Log::warning("File not found: $pathCreateOrder");
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Drop the procedure
        DB::unprepared('DROP PROCEDURE IF EXISTS spGetAllOrders');
        DB::unprepared('DROP PROCEDURE IF EXISTS spDeleteOrder');
        DB::unprepared('DROP PROCEDURE IF EXISTS spUpdateOrder');
        DB::unprepared('DROP PROCEDURE IF EXISTS spCreateOrder');
    }
};