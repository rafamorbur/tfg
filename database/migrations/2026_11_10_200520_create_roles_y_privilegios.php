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

        DB::unprepared("
            -- PostGreSql
            -- Creación de roles y privilegios para los usuarios
            -- Author: Rafael Morones Burgos.
            -- Version: 1.0.0
            -- Since: 05/10/2026

            -- Creamos las cuentas de usuarios en la BD
            --Usuario que usará nuestra aplicacion con permisos para conectarse a la base de datos
            --se crea un usuario en postgresql que el usuario de laravel se pueda conectar a la bd 
            --sin necesidad de usar el usuario root postgres
            CREATE ROLE app_user LOGIN PASSWORD '1234';
            --creamos un usuario de solo consulta
            CREATE ROLE readonly_user LOGIN PASSWORD 'otro1234';

            --El usuario de la aplicación necesita leer, insertar, modificar y eliminar
            --con grant ortogamos permisos
            GRANT CONNECT ON DATABASE port_management_malaga TO app_user;
            GRANT USAGE ON SCHEMA public TO app_user;
            GRANT SELECT, INSERT, UPDATE, DELETE ON ALL TABLES IN SCHEMA public TO app_user;
            GRANT USAGE, SELECT ON ALL SEQUENCES IN SCHEMA public TO app_user;

            -- el usuario de consulta solo necesita leer
            GRANT CONNECT ON DATABASE port_management_malaga TO readonly_user;
            GRANT USAGE ON SCHEMA public TO readonly_user;
            GRANT SELECT ON ALL TABLES IN SCHEMA public TO readonly_user;

            --quitamos por defecto los permisos a todo el mundo
            --con revoke los revocamos
            REVOKE ALL ON DATABASE port_management_malaga FROM PUBLIC;
            REVOKE ALL ON SCHEMA public FROM PUBLIC;
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Si hacemos un rollback, borramos los roles
        DB::unprepared("
            DROP ROLE IF EXISTS app_user;
            DROP ROLE IF EXISTS readonly_user;
        ");
    }
};