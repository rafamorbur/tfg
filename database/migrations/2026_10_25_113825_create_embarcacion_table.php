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
        Schema::create('embarcacion', function (Blueprint $table) {
            $table->id('id_embarcacion');
            $table->string('nombre', 100);
            $table->string('matricula', 50)->unique();
            $table->string('tipo', 50)->nullable();
            $table->decimal('eslora', 5, 2);
            $table->decimal('manga', 5, 2);
            $table->decimal('calado', 5, 2);
            $table->string('bandera', 50)->nullable();
            $table->string('numero_poliza_seguro', 50)->nullable();
            $table->date('vencimiento_seguro')->nullable();
            $table->string('mmsi', 20)->nullable();
            $table->integer('capacidad')->nullable();
            $table->timestamp('fecha_alta')->useCurrent();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('embarcacion');
    }
};
