<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class RelacionesSeeder extends Seeder
{
    public function run(): void
    {
        // Usuario - Embarcación (Copropiedad)
        DB::table('usuario_embarcacion')->insert([
            ['id_usuario' => 1, 'id_embarcacion' => 1, 'rol' => 'propietario'],
            ['id_usuario' => 1, 'id_embarcacion' => 2, 'rol' => 'propietario'],
            ['id_usuario' => 2, 'id_embarcacion' => 1, 'rol' => 'copropietario'],
            ['id_usuario' => 3, 'id_embarcacion' => 3, 'rol' => 'propietario'],
        ]);

        // Muelle - Servicio
        DB::table('muelle_servicio')->insert([
            ['id_muelle' => 1, 'id_servicio' => 1, 'precio' => 5.00],
            ['id_muelle' => 1, 'id_servicio' => 2, 'precio' => 8.00],
            ['id_muelle' => 2, 'id_servicio' => 1, 'precio' => 6.00],
            ['id_muelle' => 3, 'id_servicio' => 6, 'precio' => 30.00],
        ]);

        // Reservas
        DB::table('reserva')->insert([
            ['codigo_reserva' => 'RES-001', 'id_usuario' => 1, 'id_embarcacion' => 1, 'id_amarre' => 1, 'fecha_entrada' => '2026-07-01', 'fecha_salida' => '2026-07-05', 'estado' => 'confirmada', 'precio_total' => 140.00],
            ['codigo_reserva' => 'RES-002', 'id_usuario' => 3, 'id_embarcacion' => 3, 'id_amarre' => 3, 'fecha_entrada' => '2026-08-10', 'fecha_salida' => '2026-08-15', 'estado' => 'pendiente', 'precio_total' => 250.00],
        ]);

        // Reserva - Servicio
        DB::table('reserva_servicio')->insert([
            ['id_reserva' => 1, 'id_servicio' => 1, 'cantidad' => 4, 'precio_unitario' => 5.00, 'subtotal' => 20.00],
            ['id_reserva' => 1, 'id_servicio' => 2, 'cantidad' => 4, 'precio_unitario' => 8.00, 'subtotal' => 32.00],
            ['id_reserva' => 2, 'id_servicio' => 4, 'cantidad' => 2, 'precio_unitario' => 60.00, 'subtotal' => 120.00],
        ]);
    }
}
