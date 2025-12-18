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
            Schema::create('equipo', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('id_empresa');
                $table->foreign('id_empresa')->references('id')->on('empresa');
                $table->string('nombre');
                $table->text('descripcion')->nullable();
                $table->date('fecha_creacion');
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
