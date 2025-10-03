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
        // No se necesitan campos nuevos, el campo dias_vacaciones_acumulados ya existe
        // Esta migración no hace nada
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // No hay nada que revertir
    }
};
