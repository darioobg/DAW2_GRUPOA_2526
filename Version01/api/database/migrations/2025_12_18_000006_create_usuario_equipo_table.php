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
                $table->id();

                $table->primary(['id_usuario', 'id_equipo']);
                
                $table->foreign('id_usuario')->references('id')->on('usuarios')->onDelete('cascade');
                $table->foreign('id_equipo')->references('id')->on('equipos')->onDelete('cascade');
                $table->foreign('id_rol_equipo')->references('id')->on('roles_equipo');


                $table->date('fecha_alta');
                $table->boolean('activa');
                $table->timestamps();
      
            });
        }


    /**
     * Reverse the migrations.s
     */
    public function down(): void
    {
        Schema::dropIfExists('equipo');
    }
};
