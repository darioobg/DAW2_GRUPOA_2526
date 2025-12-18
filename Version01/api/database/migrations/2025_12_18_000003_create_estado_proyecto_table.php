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
            Schema::create('estado_proyecto', function (Blueprint $table) {
                $table->id();
                $table->string('nombre');
                $table->enum('estado', ['activo', 'archivado']);
                $table->timestamps();
            });
        }


    /**
     * Reverse the migrations.s
     */
    public function down(): void
    {
        Schema::dropIfExists('estado_proyecto');
    }
};
