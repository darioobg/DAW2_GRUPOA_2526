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
        Schema::create('comentario', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_tarea')->constrained('tarea')->onDeleteCascade()->onUpdateCascade();
            $table->foreignId('id_usuario')->constrained('users')->onDeleteCascade()->onUpdateCascade();
            $table->string('texto');
            $table->date('fecha_creacion');
            $table->date('fecha_edicion');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.s
     */
    public function down(): void
    {
        Schema::dropIfExists('comentario');
    }
};
