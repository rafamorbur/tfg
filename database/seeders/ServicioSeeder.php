<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ServicioSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('servicio')->insert([
            ['nombre' => 'Agua potable', 'descripcion' => 'Suministro de agua potable en el amarre', 'categoria' => 'suministro', 'precio_base' => 5.00, 'unidad_cobro' => 'por consumo', 'activo' => true],
            ['nombre' => 'Electricidad 220V', 'descripcion' => 'Suministro eléctrico en el amarre', 'categoria' => 'suministro', 'precio_base' => 8.00, 'unidad_cobro' => 'por consumo', 'activo' => true],
            ['nombre' => 'Limpieza de embarcación', 'descripcion' => 'Limpieza exterior e interior', 'categoria' => 'limpieza', 'precio_base' => 40.00, 'unidad_cobro' => 'por servicio', 'activo' => true],
            ['nombre' => 'Mantenimiento básico', 'descripcion' => 'Revisión y pequeñas reparaciones', 'categoria' => 'mantenimiento', 'precio_base' => 60.00, 'unidad_cobro' => 'por hora', 'activo' => true],
            ['nombre' => 'Gasolina', 'descripcion' => 'Suministro de combustible en pantalán', 'categoria' => 'combustible', 'precio_base' => 1.80, 'unidad_cobro' => 'por consumo', 'activo' => true],
            ['nombre' => 'Alquiler de aparejos', 'descripcion' => 'Alquiler de equipamiento de pesca o navegación', 'categoria' => 'alquiler', 'precio_base' => 25.00, 'unidad_cobro' => 'por día', 'activo' => true],
            ['nombre' => 'Marinería', 'descripcion' => 'Servicio de marinería para atraque y desatraque', 'categoria' => 'personal', 'precio_base' => 30.00, 'unidad_cobro' => 'por servicio', 'activo' => true],
            ['nombre' => 'Catering', 'descripcion' => 'Servicio exclusivo de atención a bordo', 'categoria' => 'personal', 'precio_base' => 150.00, 'unidad_cobro' => 'por servicio', 'activo' => true],
        ]);
    }
}