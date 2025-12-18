<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('proyecto', function (Blueprint $table) {
            $table->id(); // PK

            $table->unsignedInteger('id_equipo'); // FK
            $table->string('nombre');
            $table->text('descripcion');
            $table->date('fecha_creacion');
            $table->date('fecha_inicio');
            $table->date('fecha_fin_prevista');

            $table->unsignedInteger('id_estado_proyecto'); // FK

            $table->timestamps();

            // FKs
            $table->foreign('id_equipo')
                ->references('id_equipo')
                ->on('equipo')
                ->onDelete('cascade');

            $table->foreign('id_estado_proyecto')
                ->references('id_estado_proyecto')
                ->on('estado_proyecto')
                ->onDelete('restrict');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('proyecto');
    }
};

