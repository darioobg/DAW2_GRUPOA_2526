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
            Schema::create('notificacion', function (Blueprint $table) {
                $table->id();
                $table->Integer('id_tarea')
                $table->foreign('id_tarea')->references('id')->on('tarea')
                $table->Integer('id_usuario_destino');
                $table->foreign('id_usuario_destino')->references('id')->on('usuario');
                $table->Integer('id_tipo_notificacion');
                $table->foreign('id_tipo_notificacion')references('id')->on('tipo_notificacion');
                $table->Integer('id_canal_notificacion');
                $table->foreign('id_canal_notificacion')->references('id')->on('canal_notificacion')
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
