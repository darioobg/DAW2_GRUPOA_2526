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
        Schema::create('notificacion', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_tarea')->constrained('tarea')->onDeleteCascade()->onUpdateCascade();
            $table->foreignId('id_usuario_destino')->constrained('users')->onDeleteCascade()->onUpdateCascade();
            $table->foreignId('id_tipo_notificacion')->constrained('tipo_notificacion')->onDeleteRestrict()->onUpdateCascade();
            $table->foreignId('id_canal_notificacion')->constrained('canal_notificacion')->onDeleteRestrict()->onUpdateCascade();
            $table->string('mensaje');
            $table->boolean('leida');
            $table->date('fecha_envio');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.s
     */
    public function down(): void
    {
        Schema::dropIfExists('notificacion');
    }
};
