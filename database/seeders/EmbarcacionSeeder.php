<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EmbarcacionSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('embarcacion')->insert([
            ['nombre' => 'El Corsario', 'matricula' => 'MAT-1234', 'tipo' => 'Velero', 'eslora' => 12.50, 'manga' => 4.20, 'calado' => 1.80, 'bandera' => 'Española', 'numero_poliza_seguro' => 'POL-987654', 'vencimiento_seguro' => '2027-06-30', 'mmsi' => '123456789', 'capacidad' => 8],
            ['nombre' => 'La Sirena', 'matricula' => 'MAT-5678', 'tipo' => 'Motora', 'eslora' => 8.00, 'manga' => 3.00, 'calado' => 1.20, 'bandera' => 'Española', 'numero_poliza_seguro' => 'POL-123456', 'vencimiento_seguro' => '2026-12-31', 'mmsi' => '987654321', 'capacidad' => 6],
            ['nombre' => 'Poseidón', 'matricula' => 'MAT-9012', 'tipo' => 'Catamarán', 'eslora' => 15.00, 'manga' => 6.50, 'calado' => 2.10, 'bandera' => 'Española', 'numero_poliza_seguro' => 'POL-555555', 'vencimiento_seguro' => '2028-03-15', 'mmsi' => '456789123', 'capacidad' => 12],
            ['nombre' => 'Estrella del Sur', 'matricula' => 'MAT-3456', 'tipo' => 'Yate', 'eslora' => 20.00, 'manga' => 5.50, 'calado' => 2.50, 'bandera' => 'Española', 'numero_poliza_seguro' => 'POL-777777', 'vencimiento_seguro' => '2027-09-20', 'mmsi' => '789123456', 'capacidad' => 10],
            ['nombre' => 'Titan', 'matricula' => 'MAT-0001', 'tipo' => 'Superyate', 'eslora' => 45.00, 'manga' => 9.00, 'calado' => 4.50, 'bandera' => 'Española', 'numero_poliza_seguro' => 'POL-999999', 'vencimiento_seguro' => '2029-01-01', 'mmsi' => '111111111', 'capacidad' => 25],
            ['nombre' => 'Marea Azul', 'matricula' => 'MAT-1111', 'tipo' => 'Velero', 'eslora' => 10.00, 'manga' => 3.50, 'calado' => 1.50, 'bandera' => 'Española', 'numero_poliza_seguro' => 'POL-111111', 'vencimiento_seguro' => '2027-05-10', 'mmsi' => '222222222', 'capacidad' => 6],
            ['nombre' => 'Viento Norte', 'matricula' => 'MAT-2222', 'tipo' => 'Motora', 'eslora' => 7.00, 'manga' => 2.80, 'calado' => 1.10, 'bandera' => 'Española', 'numero_poliza_seguro' => 'POL-222222', 'vencimiento_seguro' => '2026-10-15', 'mmsi' => '333333333', 'capacidad' => 5],
            ['nombre' => 'Náutica', 'matricula' => 'MAT-3333', 'tipo' => 'Lancha', 'eslora' => 5.50, 'manga' => 2.20, 'calado' => 0.80, 'bandera' => 'Española', 'numero_poliza_seguro' => 'POL-333333', 'vencimiento_seguro' => '2027-01-20', 'mmsi' => '444444444', 'capacidad' => 4],
            ['nombre' => 'Aurora', 'matricula' => 'MAT-4444', 'tipo' => 'Velero', 'eslora' => 14.00, 'manga' => 4.50, 'calado' => 2.00, 'bandera' => 'Española', 'numero_poliza_seguro' => 'POL-444444', 'vencimiento_seguro' => '2028-07-11', 'mmsi' => '555555555', 'capacidad' => 8],
            ['nombre' => 'Fortuna', 'matricula' => 'MAT-5555', 'tipo' => 'Yate', 'eslora' => 18.00, 'manga' => 5.00, 'calado' => 2.20, 'bandera' => 'Española', 'numero_poliza_seguro' => 'POL-555555', 'vencimiento_seguro' => '2027-11-30', 'mmsi' => '666666666', 'capacidad' => 12],
            ['nombre' => 'Ola Fresca', 'matricula' => 'MAT-6666', 'tipo' => 'Motora', 'eslora' => 9.00, 'manga' => 3.20, 'calado' => 1.30, 'bandera' => 'Española', 'numero_poliza_seguro' => 'POL-666666', 'vencimiento_seguro' => '2026-08-25', 'mmsi' => '777777777', 'capacidad' => 6],
            ['nombre' => 'Mar Abierto', 'matricula' => 'MAT-7777', 'tipo' => 'Catamarán', 'eslora' => 16.00, 'manga' => 7.00, 'calado' => 2.00, 'bandera' => 'Española', 'numero_poliza_seguro' => 'POL-777777', 'vencimiento_seguro' => '2028-02-14', 'mmsi' => '888888888', 'capacidad' => 15],
            ['nombre' => 'Brisa', 'matricula' => 'MAT-8888', 'tipo' => 'Velero', 'eslora' => 11.00, 'manga' => 3.80, 'calado' => 1.70, 'bandera' => 'Española', 'numero_poliza_seguro' => 'POL-888888', 'vencimiento_seguro' => '2027-04-05', 'mmsi' => '999999999', 'capacidad' => 7],
            ['nombre' => 'El Delfín', 'matricula' => 'MAT-9999', 'tipo' => 'Lancha', 'eslora' => 6.00, 'manga' => 2.50, 'calado' => 1.00, 'bandera' => 'Española', 'numero_poliza_seguro' => 'POL-999999', 'vencimiento_seguro' => '2026-09-18', 'mmsi' => '101010101', 'capacidad' => 5],
            ['nombre' => 'Tritón', 'matricula' => 'MAT-1010', 'tipo' => 'Motora', 'eslora' => 13.00, 'manga' => 4.00, 'calado' => 1.90, 'bandera' => 'Española', 'numero_poliza_seguro' => 'POL-101010', 'vencimiento_seguro' => '2028-12-01', 'mmsi' => '121212121', 'capacidad' => 8],
        ]);
    }
}