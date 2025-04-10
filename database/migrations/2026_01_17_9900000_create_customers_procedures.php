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
        DB::unprepared('DROP PROCEDURE IF EXISTS createCustomer');
        DB::unprepared('DROP PROCEDURE IF EXISTS updateCustomer');

        // Create procedures
        $pathGetAll = database_path('sp/CustomersSP/getAllCustomersSP.sql');
        DB::unprepared(File::get($pathGetAll));

        $pathGetById = database_path('sp/CustomersSP/getCustomerByIdSP.sql');
        DB::unprepared(File::get($pathGetById));

        $pathCreate = database_path('sp/CustomersSP/createCustomerSP.sql');
        DB::unprepared(File::get($pathCreate));

        $pathUpdate = database_path('sp/CustomersSP/updateCustomerSP.sql');
        DB::unprepared(File::get($pathUpdate));
    }

    public function down(): void
    {
        DB::unprepared('DROP PROCEDURE IF EXISTS getAllCustomers');
        DB::unprepared('DROP PROCEDURE IF EXISTS getCustomerById');
        DB::unprepared('DROP PROCEDURE IF EXISTS createCustomer');
        DB::unprepared('DROP PROCEDURE IF EXISTS updateCustomer');
    }
};
