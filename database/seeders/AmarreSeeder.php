<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class AmarreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('amarre')->insert([
            ['id_muelle' => 1, 'numero' => 'A-01', 'eslora_max' => 12.00, 'manga_max' => 4.00, 'calado_max' => 1.80, 'estado' => 'disponible', 'tarifa_base' => 35.00],
            ['id_muelle' => 1, 'numero' => 'A-02', 'eslora_max' => 10.00, 'manga_max' => 3.50, 'calado_max' => 1.50, 'estado' => 'ocupado', 'tarifa_base' => 30.00],
            ['id_muelle' => 2, 'numero' => 'F-01', 'eslora_max' => 8.00, 'manga_max' => 3.00, 'calado_max' => 1.20, 'estado' => 'disponible', 'tarifa_base' => 25.00],
            ['id_muelle' => 3, 'numero' => 'C-01', 'eslora_max' => 15.00, 'manga_max' => 5.00, 'calado_max' => 2.00, 'estado' => 'mantenimiento', 'tarifa_base' => 50.00],
            ['id_muelle' => 4, 'numero' => 'M-01', 'eslora_max' => 20.00, 'manga_max' => 5.50, 'calado_max' => 2.50, 'estado' => 'disponible', 'tarifa_base' => 65.00],
        ]);
    }
}
