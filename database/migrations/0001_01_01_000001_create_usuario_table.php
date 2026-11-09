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
        Schema::create('usuario', function (Blueprint $table) {
            $table->id('id_usuario');
            $table->string('nombre', 100);
            $table->string('apellidos', 150);
            $table->string('email', 255)->unique();
            $table->string('password', 255);
            $table->string('telefono', 20)->nullable();
            $table->string('documento_tipo', 20);
            $table->string('numero_documento', 30)->unique();
            $table->string('direccion', 255)->nullable();
            $table->timestamp('fecha_registro')->useCurrent();
            $table->boolean('activo')->default(true);
            $table->foreignId('id_rol')->constrained('rol', 'id_rol');
            $table->foreignId('id_muelle')->nullable()->constrained('muelle', 'id_muelle')->nullOnDelete();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
