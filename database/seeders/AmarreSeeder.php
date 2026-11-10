<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AmarreSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('amarre')->insert([
            //  Benalmádena 
            ['id_muelle' => 1, 'numero' => 'A-01', 'eslora_max' => 12.00, 'manga_max' => 4.00, 'calado_max' => 1.80, 'estado' => 'disponible', 'tarifa_base' => 35.00],
            ['id_muelle' => 1, 'numero' => 'A-02', 'eslora_max' => 10.00, 'manga_max' => 3.50, 'calado_max' => 1.50, 'estado' => 'ocupado', 'tarifa_base' => 30.00],
            ['id_muelle' => 1, 'numero' => 'A-03', 'eslora_max' => 8.00, 'manga_max' => 3.00, 'calado_max' => 1.20, 'estado' => 'disponible', 'tarifa_base' => 25.00],
            ['id_muelle' => 1, 'numero' => 'A-04', 'eslora_max' => 15.00, 'manga_max' => 5.00, 'calado_max' => 2.00, 'estado' => 'disponible', 'tarifa_base' => 50.00],
            ['id_muelle' => 1, 'numero' => 'A-05', 'eslora_max' => 12.00, 'manga_max' => 4.00, 'calado_max' => 1.80, 'estado' => 'disponible', 'tarifa_base' => 35.00],
            ['id_muelle' => 1, 'numero' => 'A-06', 'eslora_max' => 20.00, 'manga_max' => 6.00, 'calado_max' => 2.50, 'estado' => 'disponible', 'tarifa_base' => 70.00],
            ['id_muelle' => 1, 'numero' => 'A-07', 'eslora_max' => 10.00, 'manga_max' => 3.50, 'calado_max' => 1.50, 'estado' => 'disponible', 'tarifa_base' => 30.00],
            ['id_muelle' => 1, 'numero' => 'A-08', 'eslora_max' => 8.00, 'manga_max' => 3.00, 'calado_max' => 1.20, 'estado' => 'disponible', 'tarifa_base' => 25.00],
            ['id_muelle' => 1, 'numero' => 'A-09', 'eslora_max' => 15.00, 'manga_max' => 5.00, 'calado_max' => 2.00, 'estado' => 'disponible', 'tarifa_base' => 50.00],
            ['id_muelle' => 1, 'numero' => 'A-10', 'eslora_max' => 12.00, 'manga_max' => 4.00, 'calado_max' => 1.80, 'estado' => 'disponible', 'tarifa_base' => 35.00],

            // Fuengirola 
            ['id_muelle' => 2, 'numero' => 'F-01', 'eslora_max' => 8.00, 'manga_max' => 3.00, 'calado_max' => 1.20, 'estado' => 'disponible', 'tarifa_base' => 25.00],
            ['id_muelle' => 2, 'numero' => 'F-02', 'eslora_max' => 10.00, 'manga_max' => 3.50, 'calado_max' => 1.50, 'estado' => 'mantenimiento', 'tarifa_base' => 28.00],
            ['id_muelle' => 2, 'numero' => 'F-03', 'eslora_max' => 12.00, 'manga_max' => 4.00, 'calado_max' => 1.80, 'estado' => 'disponible', 'tarifa_base' => 35.00],
            ['id_muelle' => 2, 'numero' => 'F-04', 'eslora_max' => 15.00, 'manga_max' => 5.00, 'calado_max' => 2.00, 'estado' => 'disponible', 'tarifa_base' => 45.00],
            ['id_muelle' => 2, 'numero' => 'F-05', 'eslora_max' => 8.00, 'manga_max' => 3.00, 'calado_max' => 1.20, 'estado' => 'disponible', 'tarifa_base' => 25.00],
            ['id_muelle' => 2, 'numero' => 'F-06', 'eslora_max' => 10.00, 'manga_max' => 3.50, 'calado_max' => 1.50, 'estado' => 'disponible', 'tarifa_base' => 28.00],
            ['id_muelle' => 2, 'numero' => 'F-07', 'eslora_max' => 12.00, 'manga_max' => 4.00, 'calado_max' => 1.80, 'estado' => 'disponible', 'tarifa_base' => 35.00],
            ['id_muelle' => 2, 'numero' => 'F-08', 'eslora_max' => 15.00, 'manga_max' => 5.00, 'calado_max' => 2.00, 'estado' => 'disponible', 'tarifa_base' => 45.00],
            ['id_muelle' => 2, 'numero' => 'F-09', 'eslora_max' => 20.00, 'manga_max' => 6.00, 'calado_max' => 2.50, 'estado' => 'disponible', 'tarifa_base' => 65.00],
            ['id_muelle' => 2, 'numero' => 'F-10', 'eslora_max' => 10.00, 'manga_max' => 3.50, 'calado_max' => 1.50, 'estado' => 'disponible', 'tarifa_base' => 28.00],

            // Cabopino 
            ['id_muelle' => 3, 'numero' => 'C-01', 'eslora_max' => 12.00, 'manga_max' => 4.00, 'calado_max' => 1.80, 'estado' => 'disponible', 'tarifa_base' => 32.00],
            ['id_muelle' => 3, 'numero' => 'C-02', 'eslora_max' => 15.00, 'manga_max' => 5.00, 'calado_max' => 2.00, 'estado' => 'disponible', 'tarifa_base' => 45.00],
            ['id_muelle' => 3, 'numero' => 'C-03', 'eslora_max' => 15.00, 'manga_max' => 5.50, 'calado_max' => 2.10, 'estado' => 'disponible', 'tarifa_base' => 48.00],
            ['id_muelle' => 3, 'numero' => 'C-04', 'eslora_max' => 10.00, 'manga_max' => 3.50, 'calado_max' => 1.50, 'estado' => 'disponible', 'tarifa_base' => 28.00],
            ['id_muelle' => 3, 'numero' => 'C-05', 'eslora_max' => 8.00, 'manga_max' => 3.00, 'calado_max' => 1.20, 'estado' => 'disponible', 'tarifa_base' => 25.00],
            ['id_muelle' => 3, 'numero' => 'C-06', 'eslora_max' => 12.00, 'manga_max' => 4.00, 'calado_max' => 1.80, 'estado' => 'disponible', 'tarifa_base' => 32.00],
            ['id_muelle' => 3, 'numero' => 'C-07', 'eslora_max' => 20.00, 'manga_max' => 6.00, 'calado_max' => 2.50, 'estado' => 'disponible', 'tarifa_base' => 65.00],
            ['id_muelle' => 3, 'numero' => 'C-08', 'eslora_max' => 15.00, 'manga_max' => 5.00, 'calado_max' => 2.00, 'estado' => 'disponible', 'tarifa_base' => 45.00],
            ['id_muelle' => 3, 'numero' => 'C-09', 'eslora_max' => 10.00, 'manga_max' => 3.50, 'calado_max' => 1.50, 'estado' => 'disponible', 'tarifa_base' => 28.00],
            ['id_muelle' => 3, 'numero' => 'C-10', 'eslora_max' => 12.00, 'manga_max' => 4.00, 'calado_max' => 1.80, 'estado' => 'disponible', 'tarifa_base' => 32.00],

            // Marbella 
            ['id_muelle' => 4, 'numero' => 'M-01', 'eslora_max' => 20.00, 'manga_max' => 5.50, 'calado_max' => 2.50, 'estado' => 'disponible', 'tarifa_base' => 65.00],
            ['id_muelle' => 4, 'numero' => 'M-02', 'eslora_max' => 15.00, 'manga_max' => 5.00, 'calado_max' => 2.00, 'estado' => 'disponible', 'tarifa_base' => 50.00],
            ['id_muelle' => 4, 'numero' => 'M-03', 'eslora_max' => 12.00, 'manga_max' => 4.00, 'calado_max' => 1.80, 'estado' => 'disponible', 'tarifa_base' => 40.00],
            ['id_muelle' => 4, 'numero' => 'M-04', 'eslora_max' => 10.00, 'manga_max' => 3.50, 'calado_max' => 1.50, 'estado' => 'disponible', 'tarifa_base' => 35.00],
            ['id_muelle' => 4, 'numero' => 'M-05', 'eslora_max' => 8.00, 'manga_max' => 3.00, 'calado_max' => 1.20, 'estado' => 'disponible', 'tarifa_base' => 30.00],
            ['id_muelle' => 4, 'numero' => 'M-06', 'eslora_max' => 15.00, 'manga_max' => 5.00, 'calado_max' => 2.00, 'estado' => 'disponible', 'tarifa_base' => 50.00],
            ['id_muelle' => 4, 'numero' => 'M-07', 'eslora_max' => 20.00, 'manga_max' => 5.50, 'calado_max' => 2.50, 'estado' => 'disponible', 'tarifa_base' => 65.00],
            ['id_muelle' => 4, 'numero' => 'M-08', 'eslora_max' => 12.00, 'manga_max' => 4.00, 'calado_max' => 1.80, 'estado' => 'disponible', 'tarifa_base' => 40.00],
            ['id_muelle' => 4, 'numero' => 'M-09', 'eslora_max' => 10.00, 'manga_max' => 3.50, 'calado_max' => 1.50, 'estado' => 'disponible', 'tarifa_base' => 35.00],
            ['id_muelle' => 4, 'numero' => 'M-10', 'eslora_max' => 8.00, 'manga_max' => 3.00, 'calado_max' => 1.20, 'estado' => 'disponible', 'tarifa_base' => 30.00],

            // Puerto Banús
            ['id_muelle' => 5, 'numero' => 'B-01', 'eslora_max' => 25.00, 'manga_max' => 6.50, 'calado_max' => 3.00, 'estado' => 'disponible', 'tarifa_base' => 120.00],
            ['id_muelle' => 5, 'numero' => 'B-02', 'eslora_max' => 20.00, 'manga_max' => 6.00, 'calado_max' => 2.50, 'estado' => 'disponible', 'tarifa_base' => 90.00],
            ['id_muelle' => 5, 'numero' => 'B-03', 'eslora_max' => 15.00, 'manga_max' => 5.00, 'calado_max' => 2.00, 'estado' => 'disponible', 'tarifa_base' => 70.00],
            ['id_muelle' => 5, 'numero' => 'B-04', 'eslora_max' => 12.00, 'manga_max' => 4.00, 'calado_max' => 1.80, 'estado' => 'disponible', 'tarifa_base' => 50.00],
            ['id_muelle' => 5, 'numero' => 'B-05', 'eslora_max' => 10.00, 'manga_max' => 3.50, 'calado_max' => 1.50, 'estado' => 'disponible', 'tarifa_base' => 40.00],
            ['id_muelle' => 5, 'numero' => 'B-06', 'eslora_max' => 25.00, 'manga_max' => 6.50, 'calado_max' => 3.00, 'estado' => 'disponible', 'tarifa_base' => 120.00],
            ['id_muelle' => 5, 'numero' => 'B-07', 'eslora_max' => 20.00, 'manga_max' => 6.00, 'calado_max' => 2.50, 'estado' => 'disponible', 'tarifa_base' => 90.00],
            ['id_muelle' => 5, 'numero' => 'B-08', 'eslora_max' => 15.00, 'manga_max' => 5.00, 'calado_max' => 2.00, 'estado' => 'disponible', 'tarifa_base' => 70.00],
            ['id_muelle' => 5, 'numero' => 'B-09', 'eslora_max' => 12.00, 'manga_max' => 4.00, 'calado_max' => 1.80, 'estado' => 'disponible', 'tarifa_base' => 50.00],
            ['id_muelle' => 5, 'numero' => 'B-10', 'eslora_max' => 10.00, 'manga_max' => 3.50, 'calado_max' => 1.50, 'estado' => 'disponible', 'tarifa_base' => 40.00],

            // Estepona 
            ['id_muelle' => 6, 'numero' => 'E-01', 'eslora_max' => 15.00, 'manga_max' => 5.00, 'calado_max' => 2.00, 'estado' => 'disponible', 'tarifa_base' => 45.00],
            ['id_muelle' => 6, 'numero' => 'E-02', 'eslora_max' => 12.00, 'manga_max' => 4.00, 'calado_max' => 1.80, 'estado' => 'disponible', 'tarifa_base' => 35.00],
            ['id_muelle' => 6, 'numero' => 'E-03', 'eslora_max' => 10.00, 'manga_max' => 3.50, 'calado_max' => 1.50, 'estado' => 'disponible', 'tarifa_base' => 28.00],
            ['id_muelle' => 6, 'numero' => 'E-04', 'eslora_max' => 8.00, 'manga_max' => 3.00, 'calado_max' => 1.20, 'estado' => 'disponible', 'tarifa_base' => 25.00],
            ['id_muelle' => 6, 'numero' => 'E-05', 'eslora_max' => 20.00, 'manga_max' => 6.00, 'calado_max' => 2.50, 'estado' => 'disponible', 'tarifa_base' => 65.00],
            ['id_muelle' => 6, 'numero' => 'E-06', 'eslora_max' => 15.00, 'manga_max' => 5.00, 'calado_max' => 2.00, 'estado' => 'disponible', 'tarifa_base' => 45.00],
            ['id_muelle' => 6, 'numero' => 'E-07', 'eslora_max' => 12.00, 'manga_max' => 4.00, 'calado_max' => 1.80, 'estado' => 'disponible', 'tarifa_base' => 35.00],
            ['id_muelle' => 6, 'numero' => 'E-08', 'eslora_max' => 10.00, 'manga_max' => 3.50, 'calado_max' => 1.50, 'estado' => 'disponible', 'tarifa_base' => 28.00],
            ['id_muelle' => 6, 'numero' => 'E-09', 'eslora_max' => 8.00, 'manga_max' => 3.00, 'calado_max' => 1.20, 'estado' => 'disponible', 'tarifa_base' => 25.00],
            ['id_muelle' => 6, 'numero' => 'E-10', 'eslora_max' => 20.00, 'manga_max' => 6.00, 'calado_max' => 2.50, 'estado' => 'disponible', 'tarifa_base' => 65.00],

            // La Duquesa 
            ['id_muelle' => 7, 'numero' => 'D-01', 'eslora_max' => 12.00, 'manga_max' => 4.00, 'calado_max' => 1.80, 'estado' => 'disponible', 'tarifa_base' => 35.00],
            ['id_muelle' => 7, 'numero' => 'D-02', 'eslora_max' => 15.00, 'manga_max' => 5.00, 'calado_max' => 2.00, 'estado' => 'disponible', 'tarifa_base' => 45.00],
            ['id_muelle' => 7, 'numero' => 'D-03', 'eslora_max' => 20.00, 'manga_max' => 6.00, 'calado_max' => 2.50, 'estado' => 'disponible', 'tarifa_base' => 65.00],
            ['id_muelle' => 7, 'numero' => 'D-04', 'eslora_max' => 10.00, 'manga_max' => 3.50, 'calado_max' => 1.50, 'estado' => 'disponible', 'tarifa_base' => 28.00],
            ['id_muelle' => 7, 'numero' => 'D-05', 'eslora_max' => 8.00, 'manga_max' => 3.00, 'calado_max' => 1.20, 'estado' => 'disponible', 'tarifa_base' => 25.00],
            ['id_muelle' => 7, 'numero' => 'D-06', 'eslora_max' => 12.00, 'manga_max' => 4.00, 'calado_max' => 1.80, 'estado' => 'disponible', 'tarifa_base' => 35.00],
            ['id_muelle' => 7, 'numero' => 'D-07', 'eslora_max' => 15.00, 'manga_max' => 5.00, 'calado_max' => 2.00, 'estado' => 'disponible', 'tarifa_base' => 45.00],
            ['id_muelle' => 7, 'numero' => 'D-08', 'eslora_max' => 20.00, 'manga_max' => 6.00, 'calado_max' => 2.50, 'estado' => 'disponible', 'tarifa_base' => 65.00],
            ['id_muelle' => 7, 'numero' => 'D-09', 'eslora_max' => 10.00, 'manga_max' => 3.50, 'calado_max' => 1.50, 'estado' => 'disponible', 'tarifa_base' => 28.00],
            ['id_muelle' => 7, 'numero' => 'D-10', 'eslora_max' => 8.00, 'manga_max' => 3.00, 'calado_max' => 1.20, 'estado' => 'disponible', 'tarifa_base' => 25.00],

            //  El Candado 
            ['id_muelle' => 8, 'numero' => 'K-01', 'eslora_max' => 10.00, 'manga_max' => 3.50, 'calado_max' => 1.50, 'estado' => 'disponible', 'tarifa_base' => 30.00],
            ['id_muelle' => 8, 'numero' => 'K-02', 'eslora_max' => 12.00, 'manga_max' => 4.00, 'calado_max' => 1.80, 'estado' => 'disponible', 'tarifa_base' => 40.00],
            ['id_muelle' => 8, 'numero' => 'K-03', 'eslora_max' => 8.00, 'manga_max' => 3.00, 'calado_max' => 1.20, 'estado' => 'disponible', 'tarifa_base' => 25.00],
            ['id_muelle' => 8, 'numero' => 'K-04', 'eslora_max' => 15.00, 'manga_max' => 5.00, 'calado_max' => 2.00, 'estado' => 'disponible', 'tarifa_base' => 50.00],
            ['id_muelle' => 8, 'numero' => 'K-05', 'eslora_max' => 20.00, 'manga_max' => 6.00, 'calado_max' => 2.50, 'estado' => 'disponible', 'tarifa_base' => 70.00],
            ['id_muelle' => 8, 'numero' => 'K-06', 'eslora_max' => 10.00, 'manga_max' => 3.50, 'calado_max' => 1.50, 'estado' => 'disponible', 'tarifa_base' => 30.00],
            ['id_muelle' => 8, 'numero' => 'K-07', 'eslora_max' => 12.00, 'manga_max' => 4.00, 'calado_max' => 1.80, 'estado' => 'disponible', 'tarifa_base' => 40.00],
            ['id_muelle' => 8, 'numero' => 'K-08', 'eslora_max' => 8.00, 'manga_max' => 3.00, 'calado_max' => 1.20, 'estado' => 'disponible', 'tarifa_base' => 25.00],
            ['id_muelle' => 8, 'numero' => 'K-09', 'eslora_max' => 15.00, 'manga_max' => 5.00, 'calado_max' => 2.00, 'estado' => 'disponible', 'tarifa_base' => 50.00],
            ['id_muelle' => 8, 'numero' => 'K-10', 'eslora_max' => 20.00, 'manga_max' => 6.00, 'calado_max' => 2.50, 'estado' => 'disponible', 'tarifa_base' => 70.00],

            // Caleta de Vélez 
            ['id_muelle' => 9, 'numero' => 'V-01', 'eslora_max' => 8.00, 'manga_max' => 3.00, 'calado_max' => 1.20, 'estado' => 'disponible', 'tarifa_base' => 20.00],
            ['id_muelle' => 9, 'numero' => 'V-02', 'eslora_max' => 10.00, 'manga_max' => 3.50, 'calado_max' => 1.50, 'estado' => 'disponible', 'tarifa_base' => 25.00],
            ['id_muelle' => 9, 'numero' => 'V-03', 'eslora_max' => 12.00, 'manga_max' => 4.00, 'calado_max' => 1.80, 'estado' => 'disponible', 'tarifa_base' => 30.00],
            ['id_muelle' => 9, 'numero' => 'V-04', 'eslora_max' => 15.00, 'manga_max' => 5.00, 'calado_max' => 2.00, 'estado' => 'disponible', 'tarifa_base' => 40.00],
            ['id_muelle' => 9, 'numero' => 'V-05', 'eslora_max' => 8.00, 'manga_max' => 3.00, 'calado_max' => 1.20, 'estado' => 'disponible', 'tarifa_base' => 20.00],
            ['id_muelle' => 9, 'numero' => 'V-06', 'eslora_max' => 10.00, 'manga_max' => 3.50, 'calado_max' => 1.50, 'estado' => 'disponible', 'tarifa_base' => 25.00],
            ['id_muelle' => 9, 'numero' => 'V-07', 'eslora_max' => 12.00, 'manga_max' => 4.00, 'calado_max' => 1.80, 'estado' => 'disponible', 'tarifa_base' => 30.00],
            ['id_muelle' => 9, 'numero' => 'V-08', 'eslora_max' => 15.00, 'manga_max' => 5.00, 'calado_max' => 2.00, 'estado' => 'disponible', 'tarifa_base' => 40.00],
            ['id_muelle' => 9, 'numero' => 'V-09', 'eslora_max' => 8.00, 'manga_max' => 3.00, 'calado_max' => 1.20, 'estado' => 'disponible', 'tarifa_base' => 20.00],
            ['id_muelle' => 9, 'numero' => 'V-10', 'eslora_max' => 10.00, 'manga_max' => 3.50, 'calado_max' => 1.50, 'estado' => 'disponible', 'tarifa_base' => 25.00],

            //  Muelle Uno - 
            ['id_muelle' => 10, 'numero' => 'S-01', 'eslora_max' => 50.00, 'manga_max' => 10.00, 'calado_max' => 5.00, 'estado' => 'disponible', 'tarifa_base' => 300.00],
            ['id_muelle' => 10, 'numero' => 'S-02', 'eslora_max' => 40.00, 'manga_max' => 8.00, 'calado_max' => 4.00, 'estado' => 'disponible', 'tarifa_base' => 250.00],
            ['id_muelle' => 10, 'numero' => 'S-03', 'eslora_max' => 35.00, 'manga_max' => 7.50, 'calado_max' => 3.50, 'estado' => 'disponible', 'tarifa_base' => 200.00],
            ['id_muelle' => 10, 'numero' => 'S-04', 'eslora_max' => 30.00, 'manga_max' => 7.00, 'calado_max' => 3.00, 'estado' => 'disponible', 'tarifa_base' => 150.00],
            ['id_muelle' => 10, 'numero' => 'S-05', 'eslora_max' => 25.00, 'manga_max' => 6.50, 'calado_max' => 3.00, 'estado' => 'disponible', 'tarifa_base' => 120.00],
            ['id_muelle' => 10, 'numero' => 'S-06', 'eslora_max' => 50.00, 'manga_max' => 10.00, 'calado_max' => 5.00, 'estado' => 'disponible', 'tarifa_base' => 300.00],
            ['id_muelle' => 10, 'numero' => 'S-07', 'eslora_max' => 40.00, 'manga_max' => 8.00, 'calado_max' => 4.00, 'estado' => 'disponible', 'tarifa_base' => 250.00],
            ['id_muelle' => 10, 'numero' => 'S-08', 'eslora_max' => 35.00, 'manga_max' => 7.50, 'calado_max' => 3.50, 'estado' => 'disponible', 'tarifa_base' => 200.00],
            ['id_muelle' => 10, 'numero' => 'S-09', 'eslora_max' => 30.00, 'manga_max' => 7.00, 'calado_max' => 3.00, 'estado' => 'disponible', 'tarifa_base' => 150.00],
            ['id_muelle' => 10, 'numero' => 'S-10', 'eslora_max' => 25.00, 'manga_max' => 6.50, 'calado_max' => 3.00, 'estado' => 'disponible', 'tarifa_base' => 120.00],
        ]);
    }
}