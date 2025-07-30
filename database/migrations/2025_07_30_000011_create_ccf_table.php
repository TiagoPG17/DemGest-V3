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
        Schema::create('ccf', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 100);
            $table->timestamps();
        });

        // Insertar datos iniciales
        \DB::table('ccf')->insert([
            ['id' => 1, 'nombre' => 'Comfama'],
            ['id' => 2, 'nombre' => 'Comfenalco'],
            ['id' => 3, 'nombre' => 'Compensar'],
            ['id' => 4, 'nombre' => 'Cafam'],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ccf');
    }
};
