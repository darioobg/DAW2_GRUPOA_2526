<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('rol_equipo', function (Blueprint $table) {
            $table->id(); // PK
            $table->enum('nombre', ['ADMIN', 'COLABORADOR'])->unique();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rol_equipo');
    }
};
