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
        Schema::create('foto_perfils', function (Blueprint $table) {
            $table->id('id_foto_perfil');
            $table->unsignedBigInteger('empleado_id');
            $table->string('ruta_archivo');
            $table->string('tipo'); // 'full' o 'thumbnail'
            $table->string('tamano');
            $table->boolean('es_actual')->default(true);
            $table->timestamps();

            // Clave foránea
            $table->foreign('empleado_id')
                  ->references('id_empleado')
                  ->on('empleados')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('foto_perfils');
    }
};
