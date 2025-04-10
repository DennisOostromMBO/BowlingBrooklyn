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
        // Drop existing procedures if they exist
        DB::unprepared('DROP PROCEDURE IF EXISTS spGetAllUsers');
        DB::unprepared('DROP PROCEDURE IF EXISTS spGetAllRoles');
        DB::unprepared('DROP PROCEDURE IF EXISTS spUpdateUser');
        DB::unprepared('DROP PROCEDURE IF EXISTS spCreateUser');
        DB::unprepared('DROP PROCEDURE IF EXISTS spUpdateUserName');
        DB::unprepared('DROP PROCEDURE IF EXISTS spUpdateUserPassword');
        DB::unprepared('DROP PROCEDURE IF EXISTS spDeleteUser');

        // Create spGetAllUsers procedure
        $pathUsers = database_path('sp/users/spGetAllUsers.sql');
        $sqlUsers = File::get($pathUsers);
        DB::unprepared($sqlUsers);

        // Create spGetAllRoles procedure
        $pathRoles = database_path('sp/roles/spGetAllRoles.sql');
        $sqlRoles = File::get($pathRoles);
        DB::unprepared($sqlRoles);

        // Create spUpdateUser procedure
        $pathUpdateUser = database_path('sp/users/spUpdateUser.sql');
        $sqlUpdateUser = File::get($pathUpdateUser);
        DB::unprepared($sqlUpdateUser);

        // Create spCreateUser procedure
        $pathCreateUser = database_path('sp/users/spCreateUser.sql');
        $sqlCreateUser = File::get($pathCreateUser);
        DB::unprepared($sqlCreateUser);

        // Create spUpdateUserName procedure
        $pathUpdateUserName = database_path('sp/users/spUpdateUserName.sql');
        $sqlUpdateUserName = File::get($pathUpdateUserName);
        DB::unprepared($sqlUpdateUserName);

        // Create spUpdateUserPassword procedure
        $pathUpdateUserPassword = database_path('sp/users/spUpdateUserPassword.sql');
        $sqlUpdateUserPassword = File::get($pathUpdateUserPassword);
        DB::unprepared($sqlUpdateUserPassword);

        // Create spDeleteUser procedure
        $pathDeleteUser = database_path('sp/users/spDeleteUser.sql');
        $sqlDeleteUser = File::get($pathDeleteUser);
        DB::unprepared($sqlDeleteUser);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Drop procedures
        DB::unprepared('DROP PROCEDURE IF EXISTS spGetAllUsers');
        DB::unprepared('DROP PROCEDURE IF EXISTS spGetAllRoles');
        DB::unprepared('DROP PROCEDURE IF EXISTS spUpdateUser');
        DB::unprepared('DROP PROCEDURE IF EXISTS spCreateUser');
        DB::unprepared('DROP PROCEDURE IF EXISTS spUpdateUserName');
        DB::unprepared('DROP PROCEDURE IF EXISTS spUpdateUserPassword');
        DB::unprepared('DROP PROCEDURE IF EXISTS spDeleteUser');
    }
};