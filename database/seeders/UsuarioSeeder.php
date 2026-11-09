<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;


class UsuarioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $password = Hash::make('Password1!');

        DB::table('usuario')->insert([
            [
                'nombre' => 'Carlos',
                'apellidos' => 'Ruiz',
                'email' => 'carlos@email.com',
                'password' => $password,
                'documento_tipo' => 'DNI',
                'numero_documento' => '12345678A',
                'id_rol' => 1,
                'id_muelle' => null
            ],
            [
                'nombre' => 'María',
                'apellidos' => 'López',
                'email' => 'maria@email.com',
                'password' => $password,
                'documento_tipo' => 'DNI',
                'numero_documento' => '87654321B',
                'id_rol' => 1,
                'id_muelle' => null
            ],
            [
                'nombre' => 'Javier',
                'apellidos' => 'Moreno',
                'email' => 'javier@email.com',
                'password' => $password,
                'documento_tipo' => 'NIE',
                'numero_documento' => 'X1234567L',
                'id_rol' => 1,
                'id_muelle' => null
            ],
            [
                'nombre' => 'Ana',
                'apellidos' => 'García',
                'email' => 'ana@puerto.es',
                'password' => $password,
                'documento_tipo' => 'DNI',
                'numero_documento' => '11223344C',
                'id_rol' => 2,
                'id_muelle' => 1
            ],
            [
                'nombre' => 'Admin',
                'apellidos' => 'PortMálaga',
                'email' => 'admin@portmalaga.com',
                'password' => $password,
                'documento_tipo' => 'DNI',
                'numero_documento' => '00000000T',
                'id_rol' => 3,
                'id_muelle' => null
            ],
        ]);
    }
}
