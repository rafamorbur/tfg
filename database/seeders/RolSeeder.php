<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class RolSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('rol')->insert([
            ['nombre' => 'cliente', 'descripcion' => 'Usuario que consulta y reserva amarres'],
            ['nombre' => 'empleado', 'descripcion' => 'Personal de puerto que gestiona amarres'],
            ['nombre' => 'administrador', 'descripcion' => 'Acceso total al sistema'],
        ]);
    }
}
