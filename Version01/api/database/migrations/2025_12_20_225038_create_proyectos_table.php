<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('proyectos', function (Blueprint $table) {
            $table->id();  // PK

            $table->string('nombre');
            $table->text('descripcion');
            $table->date('fecha_creacion');
            $table->date('fecha_inicio');
            $table->date('fecha_fin_prevista');

            $table->timestamps();

            // FKs
            $table
                ->foreignId('id_equipo')
                ->constrained('equipo')
                ->onDelete('cascade')->onUpdateCascade();

            $table
                ->foreignId('id_estado_proyecto')
                ->constrained('estado_proyecto')
                ->onDelete('restrict')->onUpdateCascade();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('proyectos');
    }
};
