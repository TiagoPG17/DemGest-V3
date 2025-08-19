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
        Schema::create('ciudades_laborales', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 150);
            $table->timestamps();
        });

        // Insertar datos iniciales
        \DB::table('ciudades_laborales')->insert([
            ['id' => 1, 'nombre' => 'medellin', 'created_at' => null, 'updated_at' => null],
            ['id' => 2, 'nombre' => 'Sabaneta', 'created_at' => null, 'updated_at' => null]
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ciudades_laborales');
    }
};
