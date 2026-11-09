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
        Schema::create('muelle_servicio', function (Blueprint $table) {
            $table->foreignId('id_muelle')->constrained('muelle', 'id_muelle')->cascadeOnDelete();
            $table->foreignId('id_servicio')->constrained('servicio', 'id_servicio')->cascadeOnDelete();
            $table->decimal('precio', 8, 2)->nullable();
            $table->boolean('disponible')->default(true);
            $table->text('observaciones')->nullable();

            //Pk compuesta
            $table->primary(['id_muelle', 'id_servicio']);
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('muelle_servicio');
    }
};
