<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class MuelleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('muelle')->insert([
            ['nombre' => 'Puerto Deportivo de Benalmádena', 'latitud' => 36.6075, 'longitud' => -4.5167, 'localidad' => 'Benalmádena', 'activo' => true],
            ['nombre' => 'Puerto Deportivo de Fuengirola', 'latitud' => 36.5417, 'longitud' => -4.6167, 'localidad' => 'Fuengirola', 'activo' => true],
            ['nombre' => 'Puerto de Cabopino', 'latitud' => 36.4833, 'longitud' => -4.7403, 'localidad' => 'Marbella', 'activo' => true],
            ['nombre' => 'Puerto Deportivo de Marbella', 'latitud' => 36.5047, 'longitud' => -4.8915, 'localidad' => 'Marbella', 'activo' => true],
            ['nombre' => 'Puerto Banús', 'latitud' => 36.4861, 'longitud' => -4.9539, 'localidad' => 'Marbella', 'activo' => true],
            ['nombre' => 'Puerto Deportivo de Estepona', 'latitud' => 36.4117, 'longitud' => -5.1499, 'localidad' => 'Estepona', 'activo' => true],
            ['nombre' => 'Puerto de La Duquesa', 'latitud' => 36.3583, 'longitud' => -5.2333, 'localidad' => 'Manilva', 'activo' => true],
            ['nombre' => 'Real Club El Candado', 'latitud' => 36.7167, 'longitud' => -4.3358, 'localidad' => 'Málaga', 'activo' => true],
        ]);
    }
}
