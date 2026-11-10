<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RelacionesSeeder extends Seeder
{
    public function run(): void
    {
        // USUARIO - EMBARCACION (Copropiedad)
        DB::table('usuario_embarcacion')->insert([

            ['id_usuario' => 1, 'id_embarcacion' => 1, 'rol' => 'propietario'],
            ['id_usuario' => 1, 'id_embarcacion' => 2, 'rol' => 'propietario'],
            ['id_usuario' => 1, 'id_embarcacion' => 5, 'rol' => 'gestor'],
    
            ['id_usuario' => 2, 'id_embarcacion' => 1, 'rol' => 'copropietario'],
    
            ['id_usuario' => 3, 'id_embarcacion' => 3, 'rol' => 'propietario'],
            ['id_usuario' => 3, 'id_embarcacion' => 4, 'rol' => 'propietario'],
   
            ['id_usuario' => 4, 'id_embarcacion' => 6, 'rol' => 'propietario'],
            ['id_usuario' => 4, 'id_embarcacion' => 7, 'rol' => 'propietario'],

            ['id_usuario' => 5, 'id_embarcacion' => 8, 'rol' => 'propietario'],
            ['id_usuario' => 5, 'id_embarcacion' => 9, 'rol' => 'propietario'],

            ['id_usuario' => 6, 'id_embarcacion' => 10, 'rol' => 'propietario'],
            ['id_usuario' => 6, 'id_embarcacion' => 11, 'rol' => 'propietario'],

            ['id_usuario' => 7, 'id_embarcacion' => 12, 'rol' => 'propietario'],
            ['id_usuario' => 7, 'id_embarcacion' => 13, 'rol' => 'propietario'],

            ['id_usuario' => 8, 'id_embarcacion' => 14, 'rol' => 'propietario'],
            ['id_usuario' => 8, 'id_embarcacion' => 15, 'rol' => 'propietario'],
        ]);

        //MUELLE - SERVICIO
        DB::table('muelle_servicio')->insert([
            ['id_muelle' => 1, 'id_servicio' => 1, 'precio' => 5.00, 'disponible' => true],
            ['id_muelle' => 1, 'id_servicio' => 2, 'precio' => 8.00, 'disponible' => true],
            ['id_muelle' => 1, 'id_servicio' => 4, 'precio' => 65.00, 'disponible' => true],
            ['id_muelle' => 2, 'id_servicio' => 1, 'precio' => 6.00, 'disponible' => true],
            ['id_muelle' => 2, 'id_servicio' => 3, 'precio' => 45.00, 'disponible' => true],
            ['id_muelle' => 3, 'id_servicio' => 1, 'precio' => 5.50, 'disponible' => true],
            ['id_muelle' => 3, 'id_servicio' => 6, 'precio' => 30.00, 'disponible' => false],
            ['id_muelle' => 4, 'id_servicio' => 1, 'precio' => 6.00, 'disponible' => true], 
            ['id_muelle' => 4, 'id_servicio' => 2, 'precio' => 9.00, 'disponible' => true],
            ['id_muelle' => 9, 'id_servicio' => 1, 'precio' => 5.00, 'disponible' => true], 
            ['id_muelle' => 9, 'id_servicio' => 2, 'precio' => 8.00, 'disponible' => true],
            ['id_muelle' => 10, 'id_servicio' => 1, 'precio' => 10.00, 'disponible' => true],
            ['id_muelle' => 10, 'id_servicio' => 2, 'precio' => 15.00, 'disponible' => true],
            ['id_muelle' => 10, 'id_servicio' => 3, 'precio' => 80.00, 'disponible' => true],
            ['id_muelle' => 10, 'id_servicio' => 8, 'precio' => 150.00, 'disponible' => true],
        ]);

        // 3. RESERVA 
        DB::table('reserva')->insert([
            // R. Confirmadas
            ['codigo_reserva' => 'RES-1001', 'id_usuario' => 1, 'id_embarcacion' => 1, 'id_amarre' => 1, 'fecha_entrada' => '2026-11-20', 'fecha_salida' => '2026-11-25', 'estado' => 'confirmada', 'precio_total' => 175.00],
            ['codigo_reserva' => 'RES-1002', 'id_usuario' => 2, 'id_embarcacion' => 1, 'id_amarre' => 4, 'fecha_entrada' => '2026-12-01', 'fecha_salida' => '2026-12-05', 'estado' => 'confirmada', 'precio_total' => 200.00],
            ['codigo_reserva' => 'RES-1003', 'id_usuario' => 3, 'id_embarcacion' => 3, 'id_amarre' => 22, 'fecha_entrada' => '2026-10-10', 'fecha_salida' => '2026-10-15', 'estado' => 'confirmada', 'precio_total' => 225.00],
            ['codigo_reserva' => 'RES-1004', 'id_usuario' => 5, 'id_embarcacion' => 9, 'id_amarre' => 33, 'fecha_entrada' => '2026-11-01', 'fecha_salida' => '2026-11-10', 'estado' => 'confirmada', 'precio_total' => 400.00],
            // R. Pendientes para que el admin los acepte
            ['codigo_reserva' => 'RES-1005', 'id_usuario' => 4, 'id_embarcacion' => 6, 'id_amarre' => 12, 'fecha_entrada' => '2026-12-20', 'fecha_salida' => '2026-12-27', 'estado' => 'pendiente', 'precio_total' => 210.00],
            ['codigo_reserva' => 'RES-1006', 'id_usuario' => 6, 'id_embarcacion' => 10, 'id_amarre' => 52, 'fecha_entrada' => '2027-01-05', 'fecha_salida' => '2027-01-12', 'estado' => 'pendiente', 'precio_total' => 315.00],
            ['codigo_reserva' => 'RES-1007', 'id_usuario' => 7, 'id_embarcacion' => 12, 'id_amarre' => 91, 'fecha_entrada' => '2027-02-01', 'fecha_salida' => '2027-02-15', 'estado' => 'pendiente', 'precio_total' => 4200.00], // Superyate Muelle Uno
            ['codigo_reserva' => 'RES-1008', 'id_usuario' => 8, 'id_embarcacion' => 14, 'id_amarre' => 81, 'fecha_entrada' => '2026-12-01', 'fecha_salida' => '2026-12-03', 'estado' => 'pendiente', 'precio_total' => 40.00],
            // R. Canceladas
            ['codigo_reserva' => 'RES-1009', 'id_usuario' => 1, 'id_embarcacion' => 2, 'id_amarre' => 2, 'fecha_entrada' => '2026-09-01', 'fecha_salida' => '2026-09-03', 'estado' => 'cancelada', 'precio_total' => 60.00],
            ['codigo_reserva' => 'RES-1010', 'id_usuario' => 3, 'id_embarcacion' => 4, 'id_amarre' => 41, 'fecha_entrada' => '2026-08-10', 'fecha_salida' => '2026-08-15', 'estado' => 'cancelada', 'precio_total' => 600.00],
        ]);

        // resera-servico--> servicios extras contratados en algunas reservas
        DB::table('reserva_servicio')->insert([
            ['id_reserva' => 1, 'id_servicio' => 1, 'cantidad' => 5, 'precio_unitario' => 5.00, 'subtotal' => 25.00],
            ['id_reserva' => 1, 'id_servicio' => 2, 'cantidad' => 5, 'precio_unitario' => 8.00, 'subtotal' => 40.00],
            ['id_reserva' => 4, 'id_servicio' => 3, 'cantidad' => 1, 'precio_unitario' => 45.00, 'subtotal' => 45.00],
            ['id_reserva' => 5, 'id_servicio' => 1, 'cantidad' => 7, 'precio_unitario' => 6.00, 'subtotal' => 42.00],
            ['id_reserva' => 7, 'id_servicio' => 8, 'cantidad' => 1, 'precio_unitario' => 150.00, 'subtotal' => 150.00],
        ]);
    }
}