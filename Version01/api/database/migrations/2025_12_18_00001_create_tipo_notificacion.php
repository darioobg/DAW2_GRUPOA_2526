<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('tipo_notificacion', function (Blueprint $table) {
            $table->id(); // PK
            $table->enum('nombre', ['ASIGNACION', 'CAMBIO_ESTADO', 'COMENTARIO'])->unique();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tipo_notificacion');
    }
};
