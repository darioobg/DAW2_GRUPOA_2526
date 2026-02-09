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
        Schema::create('tarea', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_proyectos')->constrained('proyectos')->onDeleteCascade()->onUpdateCascade();
            $table->foreignId('id_estado')->constrained('estado_tarea')->onDeleteRestrict()->onUpdateCascade();
            $table->foreignId('id_asignado_a')->constrained('users')->onDeleteCascade()->onUpdateCascade();
            $table->foreignId('id_prioridad')->constrained('prioridad')->onDeleteRestrict()->onUpdateCascade();
            $table->string('titulo');
            $table->text('descripcion')->nullable();
            $table->date('fecha_creacion');
            $table->date('fecha_limite');
            $table->date('fecha_cierre')->nullable();;
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
