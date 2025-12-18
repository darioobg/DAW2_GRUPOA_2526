<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('canal_notificacion', function (Blueprint $table) {
            $table->id(); // PK
            $table->enum('nombre', ['EMAIL', 'INAPP'])->unique();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('canal_notificacion');
    }
};
