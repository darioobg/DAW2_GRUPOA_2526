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
        Schema::create('prioridad', function (Blueprint $table) {
            $table->id();
            $table->enum('nombre', ['baja', 'media', 'alta']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.s
     */
    public function down(): void
    {
        Schema::dropIfExists('prioridad');
    }
};
