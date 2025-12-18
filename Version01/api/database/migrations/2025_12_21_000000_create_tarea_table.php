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
                $table->id();
                $table->unsignedBigInteger('id_proyectos');
                $table->unsignedBigInteger('id_prioridad');
                $table->unsignedBigInteger('id_asignado_a');
                $table->unsignedBigInteger('id_estado');
                $table->foreign('id_proyectos')->references('id')->on('proyectos');
                $table->foreign('id_estado')->references('id')->on('estado_tarea');
                $table->foreign('id_asignado_a')->references('id')->on('usuarios');
                $table->foreign('id_prioridad')->references('id')->on('prioridad');
                $table->string('titulo');
                $table->text('descripcion')->nullable();
                $table->date('fecha_creacion');
                $table->date('fecha_limite');
                $table->date('fecha_cierre');
                $table->Integer('orden_kanban');
                $table->timestamps();
            });
        }


    /**
     * Reverse the migrations.s
     */
    public function down(): void
    {
        Schema::dropIfExists('tarea');
    }
};
