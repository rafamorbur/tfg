<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('reserva', function (Blueprint $table) {
            $table->id('id_reserva');
            $table->string('codigo_reserva', 20)->unique();
            $table->foreignId('id_usuario')->constrained('usuario', 'id_usuario')->restrictOnDelete();
            $table->foreignId('id_embarcacion')->constrained('embarcacion', 'id_embarcacion')->restrictOnDelete();
            $table->foreignId('id_amarre')->constrained('amarre', 'id_amarre')->restrictOnDelete();
            $table->date('fecha_entrada');
            $table->date('fecha_salida');
            $table->string('estado', 20)->default('pendiente');
            $table->decimal('precio_total', 10, 2)->default(0);
            $table->text('observaciones')->nullable();
            $table->timestamp('fecha_creacion')->useCurrent();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reserva');
    }
};
