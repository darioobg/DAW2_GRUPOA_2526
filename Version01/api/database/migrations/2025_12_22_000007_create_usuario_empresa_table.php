<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('usuario_empresa', function (Blueprint $table) {
            $table->foreignId('id_usuario')->constrained('users')->onDeleteCascade()->onUpdateCascade();
            $table->foreignId('id_empresa')->constrained('empresa')->onDeleteCascade()->onUpdateCascade();
            $table->foreignId('id_rol_empresa')->constrained('rol_empresa')->onDeleteRestrict()->onUpdateCascade();

            $table->date('fecha_alta');
            $table->boolean('activo');
            $table->timestamps();

            $table->primary(['id_usuario', 'id_empresa']);
        });
    }

    /**
     * Reverse the migrations.s
     */
    public function down(): void
    {
        Schema::dropIfExists('usuario_empresa');
    }
};
