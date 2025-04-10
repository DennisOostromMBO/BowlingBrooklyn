<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

return new class extends Migration
{
    public function up(): void
    {
        // Drop existing procedures
        DB::unprepared('DROP PROCEDURE IF EXISTS getAllCustomers');
        DB::unprepared('DROP PROCEDURE IF EXISTS getCustomerById');

        // Create procedures
        $pathGetAll = database_path('sp/CustomersSP/getAllCustomersSP.sql');
        DB::unprepared(File::get($pathGetAll));

        $pathGetById = database_path('sp/CustomersSP/getCustomerByIdSP.sql');
        DB::unprepared(File::get($pathGetById));
    }

    public function down(): void
    {
        DB::unprepared('DROP PROCEDURE IF EXISTS getAllCustomers');
        DB::unprepared('DROP PROCEDURE IF EXISTS getCustomerById');
    }
};
