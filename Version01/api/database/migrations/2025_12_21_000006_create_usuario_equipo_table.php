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
            Schema::create('usuario_equipo', function (Blueprint $table) {
                $table->unsignedBigInteger('id_usuario');
                $table->unsignedBigInteger('id_equipo');
                $table->unsignedBigInteger('id_rol_equipo');

                $table->foreign('id_usuario')->references('id')->on('usuarios')->onDelete('cascade');
                $table->foreign('id_equipo')->references('id')->on('equipo')->onDelete('cascade');
                $table->foreign('id_rol_equipo')->references('id')->on('rol_equipo');
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
