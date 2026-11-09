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
        Schema::create('usuario_embarcacion', function (Blueprint $table) {
            $table->foreignId('id_usuario')->constrained('usuario', 'id_usuario')->cascadeOnDelete();
            $table->foreignId('id_embarcacion')->constrained('embarcacion', 'id_embarcacion')->cascadeOnDelete();
            $table->string('rol', 30)->default('propietario');
            $table->timestamp('fecha_asociacion')->useCurrent();

            // Se trata de una PK compuesta
            $table->primary(['id_usuario', 'id_embarcacion']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('usuario_embarcacion');
    }
};
