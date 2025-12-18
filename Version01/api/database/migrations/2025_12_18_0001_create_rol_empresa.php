<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('rol_empresa', function (Blueprint $table) {
            $table->increments('id_rol_empresa'); // PK
            $table->enum('nombre', ['OWNER','ADMIN', 'MIEMBRO'])->unique();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rol_empresa');
    }
};
