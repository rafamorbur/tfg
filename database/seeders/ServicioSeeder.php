<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class ServicioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('servicio')->insert([
            ['nombre' => 'Agua potable', 'categoria' => 'suministro', 'precio_base' => 5.00, 'unidad_cobro' => 'por consumo'],
            ['nombre' => 'Electricidad 220V', 'categoria' => 'suministro', 'precio_base' => 8.00, 'unidad_cobro' => 'por consumo'],
            ['nombre' => 'Limpieza de embarcación', 'categoria' => 'limpieza', 'precio_base' => 40.00, 'unidad_cobro' => 'por servicio'],
            ['nombre' => 'Mantenimiento básico', 'categoria' => 'mantenimiento', 'precio_base' => 60.00, 'unidad_cobro' => 'por hora'],
            ['nombre' => 'Gasolina', 'categoria' => 'combustible', 'precio_base' => 1.80, 'unidad_cobro' => 'por consumo'],
            ['nombre' => 'Alquiler de aparejos', 'categoria' => 'alquiler', 'precio_base' => 25.00, 'unidad_cobro' => 'por día'],
            ['nombre' => 'Marinería', 'categoria' => 'personal', 'precio_base' => 30.00, 'unidad_cobro' => 'por servicio'],
        ]);
    }
}
