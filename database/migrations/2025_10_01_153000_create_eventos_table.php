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
        Schema::create('eventos', function (Blueprint $table) {
            $table->id('id_evento');
            $table->foreignId('empleado_id')->constrained('empleados', 'id_empleado')->onDelete('cascade');
            $table->string('tipo_evento');
            $table->integer('dias');
            $table->date('fecha_inicio');
            $table->date('fecha_fin');
            $table->string('estado')->default('aprobado');
            $table->text('observaciones')->nullable();
            $table->timestamps();
            
            // Índices para mejor rendimiento
            $table->index('empleado_id');
            $table->index('tipo_evento');
            $table->index('fecha_inicio');
            $table->index('fecha_fin');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('eventos');
    }
};
