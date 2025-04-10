<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Drop and create spGetAllReservations
        DB::unprepared('DROP PROCEDURE IF EXISTS spGetAllReservations');
        $sqlGetAll = file_get_contents(database_path('sp/ReservationsSP/spGetAllReservation.sql'));
        DB::unprepared($sqlGetAll);

        // Drop and create spUpdateReservation
        DB::unprepared('DROP PROCEDURE IF EXISTS spUpdateReservation');
        $sqlUpdate = file_get_contents(database_path('sp/ReservationsSP/spUpdateReservation.sql'));
        DB::unprepared($sqlUpdate);

        // Drop and create spDeleteReservation
        DB::unprepared('DROP PROCEDURE IF EXISTS spDeleteReservation');
        $sqlDelete = file_get_contents(database_path('sp/ReservationsSP/spDeleteReservation.sql'));
        DB::unprepared($sqlDelete);

        // Drop and create spCreateReservation
        DB::unprepared('DROP PROCEDURE IF EXISTS spCreateReservation');
        $sqlCreate = file_get_contents(database_path('sp/ReservationsSP/spCreateReservation.sql'));
        DB::unprepared($sqlCreate);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared('DROP PROCEDURE IF EXISTS spGetAllReservations');
        DB::unprepared('DROP PROCEDURE IF EXISTS spUpdateReservation');
        DB::unprepared('DROP PROCEDURE IF EXISTS spDeleteReservation');
        DB::unprepared('DROP PROCEDURE IF EXISTS spCreateReservation');
    }
};
