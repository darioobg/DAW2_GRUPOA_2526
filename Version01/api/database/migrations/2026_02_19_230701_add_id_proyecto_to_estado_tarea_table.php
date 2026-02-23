<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('estado_tarea', function (Blueprint $table) {
            $table
                ->foreignId('id_proyecto')
                ->nullable()
                ->after('id')
                ->constrained('proyectos')
                ->onDelete('cascade');

            $table->integer('orden')->default(0)->change();
        });
    }

    public function down(): void
    {
        Schema::table('estado_tarea', function (Blueprint $table) {
            $table->dropForeign(['id_proyecto']);
            $table->dropColumn('id_proyecto');
        });
    }
};
