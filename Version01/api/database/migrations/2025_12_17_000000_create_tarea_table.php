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
            Schema::create('tarea', function (Blueprint $table) {
                $table->id()->primary();
                $table->foreign('id_proyectos')->references('id')->('proyectos');
                $table->foreign('id_estado')->references('id')->('estado_tarea');
                $table->foreign('id_asignado_a')->references('id')->('usuarios');
                $table->foreign('id_prioridad')->references('id')->('prioridad');
                $table->string('titulo');
                $table->text('descripcion')->nullable();
                $table->date('fecha_creacion');
                $table->date('fecha_limite');
                $table->date('fecha_cierre');
                $table->int('orden_kanban');
                $table->timestamps();
            });
        }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tarea');
    }
};
