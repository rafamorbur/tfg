<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class EmbarcacionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('embarcacion')->insert([
            ['nombre' => 'El Corsario', 'matricula' => 'MAT-1234', 'tipo' => 'Velero', 'eslora' => 12.50, 'manga' => 4.20, 'calado' => 1.80],
            ['nombre' => 'La Sirena', 'matricula' => 'MAT-5678', 'tipo' => 'Motora', 'eslora' => 8.00, 'manga' => 3.00, 'calado' => 1.20],
            ['nombre' => 'Poseidón', 'matricula' => 'MAT-9012', 'tipo' => 'Catamarán', 'eslora' => 15.00, 'manga' => 6.50, 'calado' => 2.10],
            ['nombre' => 'Estrella del Sur', 'matricula' => 'MAT-3456', 'tipo' => 'Yate', 'eslora' => 20.00, 'manga' => 5.50, 'calado' => 2.50],
        ]);
    }
}
