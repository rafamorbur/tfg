<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsuarioSeeder extends Seeder
{
    public function run(): void
    {
        $password = Hash::make('Password1!');

        DB::table('usuario')->insert([
            // --- CLIENTES ---
            ['nombre' => 'Carlos', 'apellidos' => 'Ruiz Gómez', 'email' => 'carlos@email.com', 'password' => $password, 'telefono' => '600111222', 'documento_tipo' => 'DNI', 'numero_documento' => '12345678A', 'direccion' => 'Calle Larios, 1, Málaga', 'id_rol' => 1, 'id_muelle' => null],
            ['nombre' => 'María', 'apellidos' => 'López Fernández', 'email' => 'maria@email.com', 'password' => $password, 'telefono' => '600333444', 'documento_tipo' => 'DNI', 'numero_documento' => '87654321B', 'direccion' => 'Av. Andalucía, 2, Málaga', 'id_rol' => 1, 'id_muelle' => null],
            ['nombre' => 'Javier', 'apellidos' => 'Moreno Díaz', 'email' => 'javier@email.com', 'password' => $password, 'telefono' => '600555666', 'documento_tipo' => 'NIE', 'numero_documento' => 'X1234567L', 'direccion' => 'Calle Nueva, 3, Marbella', 'id_rol' => 1, 'id_muelle' => null],
            ['nombre' => 'Luis', 'apellidos' => 'García Pérez', 'email' => 'luis@email.com', 'password' => $password, 'telefono' => '600777888', 'documento_tipo' => 'DNI', 'numero_documento' => '11223344C', 'direccion' => 'Calle Real, 4, Fuengirola', 'id_rol' => 1, 'id_muelle' => null],
            ['nombre' => 'Elena', 'apellidos' => 'Martín Ruiz', 'email' => 'elena@email.com', 'password' => $password, 'telefono' => '600999000', 'documento_tipo' => 'DNI', 'numero_documento' => '22334455D', 'direccion' => 'Av. del Mar, 5, Benalmádena', 'id_rol' => 1, 'id_muelle' => null],
            ['nombre' => 'David', 'apellidos' => 'Sánchez Gil', 'email' => 'david@email.com', 'password' => $password, 'telefono' => '611222333', 'documento_tipo' => 'DNI', 'numero_documento' => '33445566E', 'direccion' => 'Calle Sol, 6, Estepona', 'id_rol' => 1, 'id_muelle' => null],
            ['nombre' => 'Sara', 'apellidos' => 'Romero Vega', 'email' => 'sara@email.com', 'password' => $password, 'telefono' => '622333444', 'documento_tipo' => 'NIE', 'numero_documento' => 'Y9876543P', 'direccion' => 'Calle Luna, 7, Marbella', 'id_rol' => 1, 'id_muelle' => null],
            ['nombre' => 'Pablo', 'apellidos' => 'Iglesias Cano', 'email' => 'pablo@email.com', 'password' => $password, 'telefono' => '633444555', 'documento_tipo' => 'DNI', 'numero_documento' => '44556677F', 'direccion' => 'Paseo Marítimo, 8, Málaga', 'id_rol' => 1, 'id_muelle' => null],

            // --- EMPLEADOS ---
            ['nombre' => 'Ana', 'apellidos' => 'García Soler', 'email' => 'ana@puerto.es', 'password' => $password, 'telefono' => '952577000', 'documento_tipo' => 'DNI', 'numero_documento' => '55667788G', 'direccion' => 'Puerto de Benalmádena', 'id_rol' => 2, 'id_muelle' => 1], // Empleada Benalmádena
            ['nombre' => 'Pedro', 'apellidos' => 'Sánchez Vega', 'email' => 'pedro@puerto.es', 'password' => $password, 'telefono' => '952468001', 'documento_tipo' => 'DNI', 'numero_documento' => '66778899H', 'direccion' => 'Puerto de Fuengirola', 'id_rol' => 2, 'id_muelle' => 2], // Empleado Fuengirola
            ['nombre' => 'Carmen', 'apellidos' => 'Ortiz Blanco', 'email' => 'carmen@puerto.es', 'password' => $password, 'telefono' => '952000001', 'documento_tipo' => 'DNI', 'numero_documento' => '77889900J', 'direccion' => 'Puerto de Marbella', 'id_rol' => 2, 'id_muelle' => 4], // Empleada Marbella
            ['nombre' => 'Jorge', 'apellidos' => 'Navarro Soto', 'email' => 'jorge@puerto.es', 'password' => $password, 'telefono' => '952801801', 'documento_tipo' => 'DNI', 'numero_documento' => '88990011K', 'direccion' => 'Puerto de Estepona', 'id_rol' => 2, 'id_muelle' => 6], // Empleado Estepona

            // --- ADMINISTRADOR ---
            ['nombre' => 'Admin', 'apellidos' => 'PortMálaga', 'email' => 'admin@portmalaga.com', 'password' => $password, 'telefono' => '951000000', 'documento_tipo' => 'DNI', 'numero_documento' => '00000000T', 'direccion' => 'Oficina Central, Málaga', 'id_rol' => 3, 'id_muelle' => null],
        ]);
    }
}