<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MuelleSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('muelle')->insert([
            ['nombre' => 'Puerto Deportivo de Benalmádena', 'descripcion' => 'Puerto deportivo con más de 1000 amarres', 'direccion' => 'Edificio de Capitanía, 29630 Benalmádena Costa', 'localidad' => 'Benalmádena', 'provincia' => 'Málaga', 'codigo_postal' => '29630', 'latitud' => 36.5972172, 'longitud' => -4.5104814, 'telefono' => '952577022', 'email' => 'info@puertobenalmadena.es', 'horario' => 'L-D 08:00-20:00', 'activo' => true],
            ['nombre' => 'Puerto Deportivo de Fuengirola', 'descripcion' => 'Puerto con 226 atraques y servicios de marinería', 'direccion' => 'Paseo Marítimo, s/n', 'localidad' => 'Fuengirola', 'provincia' => 'Málaga', 'codigo_postal' => '29640', 'latitud' => 36.5417, 'longitud' => -4.6167, 'telefono' => '952468000', 'email' => 'puertofuengirola@hotmail.com', 'horario' => 'L-D 08:00-21:00', 'activo' => true],
            ['nombre' => 'Puerto de Cabopino', 'descripcion' => 'Puerto deportivo con 169 puestos de amarre', 'direccion' => 'Puerto de Cabopino, s/n', 'localidad' => 'Marbella', 'provincia' => 'Málaga', 'codigo_postal' => '29604', 'latitud' => 36.4847503, 'longitud' => -4.7398260, 'telefono' => '952831975', 'email' => 'info@eppa.es', 'horario' => 'L-D 09:00-19:00', 'activo' => true],
            ['nombre' => 'Puerto Deportivo de Marbella', 'descripcion' => 'Puerto deportivo con servicios de agua y electricidad', 'direccion' => 'Puerto Deportivo, s/n', 'localidad' => 'Marbella', 'provincia' => 'Málaga', 'codigo_postal' => '29602', 'latitud' => 36.5047, 'longitud' => -4.8915, 'telefono' => '952000000', 'email' => 'puertodeportivo@marbella.es', 'horario' => 'L-D 08:00-20:00', 'activo' => true],
            ['nombre' => 'Puerto Banús', 'descripcion' => 'Puerto de lujo con zona comercial y de ocio', 'direccion' => 'José Banús, s/n', 'localidad' => 'Marbella', 'provincia' => 'Málaga', 'codigo_postal' => '29660', 'latitud' => 36.4869237, 'longitud' => -4.9517075, 'telefono' => '952000000', 'email' => 'info@puertobanus.es', 'horario' => 'L-D 10:00-22:00', 'activo' => true],
            ['nombre' => 'Puerto Deportivo de Estepona', 'descripcion' => 'Puerto con 443 amarres y servicios de combustible', 'direccion' => 'Puerto Deportivo, s/n', 'localidad' => 'Estepona', 'provincia' => 'Málaga', 'codigo_postal' => '29680', 'latitud' => 36.4150160, 'longitud' => -5.1571628, 'telefono' => '952801800', 'email' => 'info@puertodeportivoestepona.com', 'horario' => 'L-D 08:00-20:00', 'activo' => true],
            ['nombre' => 'Puerto de La Duquesa', 'descripcion' => 'Puerto deportivo con 325 amarres', 'direccion' => 'Puerto de La Duquesa, s/n', 'localidad' => 'Manilva', 'provincia' => 'Málaga', 'codigo_postal' => '29692', 'latitud' => 36.3557024, 'longitud' => -5.2299005, 'telefono' => '982890100', 'email' => 'info@puertodeladuquesa.com', 'horario' => 'L-D 09:00-19:00', 'activo' => true],
            ['nombre' => 'Real Club El Candado', 'descripcion' => 'Puerto náutico con 280 amarres', 'direccion' => 'Playa de Almellones, 29720 El Palo', 'localidad' => 'Málaga', 'provincia' => 'Málaga', 'codigo_postal' => '29720', 'latitud' => 36.7145065, 'longitud' => -4.3451495, 'telefono' => '952296097', 'email' => 'administracion@clubelcandado.com', 'horario' => 'L-D 08:00-20:00', 'activo' => true],
            ['nombre' => 'Puerto Deportivo Caleta de Vélez', 'descripcion' => 'Puerto pesquero y deportivo de la Axarquía', 'direccion' => 'Paseo Marítimo, s/n', 'localidad' => 'Vélez-Málaga', 'provincia' => 'Málaga', 'codigo_postal' => '29700', 'latitud' => 36.7481731, 'longitud' => -4.0667963, 'telefono' => '952500000', 'email' => 'info@caletadevelez.es', 'horario' => 'L-D 08:00-20:00', 'activo' => true],
            ['nombre' => 'Muelle Uno', 'descripcion' => 'Muelle de lujo para superyates en el puerto de Málaga', 'direccion' => 'Paseo del Palmeral, s/n', 'localidad' => 'Málaga', 'provincia' => 'Málaga', 'codigo_postal' => '29016', 'latitud' => 36.7174685, 'longitud' => -4.4154848, 'telefono' => '951000000', 'email' => 'info@muelleuno.com', 'horario' => 'L-D 00:00-24:00', 'activo' => true],
        ]);
    }
}