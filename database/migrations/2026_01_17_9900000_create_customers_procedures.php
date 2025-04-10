<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

return new class extends Migration
{
    public function up(): void
    {
        // Drop existing procedure if it exists
        DB::unprepared('DROP PROCEDURE IF EXISTS getAllCustomers');

        // Create getAllCustomers procedure
        $pathGetAll = database_path('sp/CustomersSP/getAllCustomersSP.sql');
        DB::unprepared(File::get($pathGetAll));
    }

    public function down(): void
    {
        // Drop procedure
        DB::unprepared('DROP PROCEDURE IF EXISTS getAllCustomers');
    }
};
