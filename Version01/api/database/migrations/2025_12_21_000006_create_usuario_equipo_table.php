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
        Schema::create('usuario_equipo', function (Blueprint $table) {
            $table->foreignId('id_usuario')->constrained('users')->onDeleteCascade()->onUpdateCascade();
            $table->foreignId('id_equipo')->constrained('equipo')->onDeleteCascade()->onUpdateCascade();
            $table->foreignId('id_rol_equipo')->constrained('rol_equipo')->onDeleteRestrict()->onUpdateCascade();
            $table->primary(['id_usuario', 'id_equipo']);
            $table->date('fecha_alta');
            $table->boolean('activo');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.s
     */
    public function down(): void
    {
        Schema::dropIfExists('usuario_equipo');
    }
};
