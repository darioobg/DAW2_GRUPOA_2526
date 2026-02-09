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
        Schema::create('usuario_empresa', function (Blueprint $table) {
            $table->unsignedBigInteger('id_usuario');
            $table->unsignedBigInteger('id_empresa');
            $table->unsignedBigInteger('id_rol_empresa');

            $table->foreign('id_usuario')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('id_empresa')->references('id')->on('empresa')->onDelete('cascade');
            $table->foreign('id_rol_empresa')->references('id')->on('rol_empresa');

            $table->date('fecha_alta');
            $table->boolean('activo');
            $table->timestamps();

            $table->primary(['id_usuario', 'id_empresa']);
        });
    }

    /**
     * Reverse the migrations.s
     */
    public function down(): void
    {
        Schema::dropIfExists('usuario_empresa');
    }
};
