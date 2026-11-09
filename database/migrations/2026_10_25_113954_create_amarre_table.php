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
        Schema::create('amarre', function (Blueprint $table) {
            $table->id('id_amarre');
            // Con esta FK apuntamos a muelle
            $table->foreignId('id_muelle')->constrained('muelle', 'id_muelle')->onDelete('cascade');
            $table->string('numero', 20);
            $table->decimal('eslora_max', 5, 2);
            $table->decimal('manga_max', 5, 2);
            $table->decimal('calado_max', 5, 2);
            $table->string('estado', 20)->default('disponible');
            $table->decimal('tarifa_base', 8, 2);
            $table->text('observaciones')->nullable();
            $table->boolean('activo')->default(true);
            $table->timestamp('fecha_alta')->useCurrent();
            $table->timestamps();

            // Con esta restricción impedimos que dos amarres tenga el mismo numero en el mismo muelle
            $table->unique(['id_muelle', 'numero']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('amarre');
    }
};
