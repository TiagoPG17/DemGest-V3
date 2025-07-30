

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
        Schema::create('grupo_sanguineo', function (Blueprint $table) {
            $table->unsignedInteger('id')->primary();
            $table->string('nombre', 5);
        });

        // Insertar datos iniciales
        \DB::table('grupo_sanguineo')->insert([
            ['id' => 1, 'nombre' => 'A+'],
            ['id' => 2, 'nombre' => 'A-'],
            ['id' => 5, 'nombre' => 'AB+'],
            ['id' => 6, 'nombre' => 'AB-'],
            ['id' => 3, 'nombre' => 'B+'],
            ['id' => 4, 'nombre' => 'B-'],
            ['id' => 7, 'nombre' => 'O+'],
            ['id' => 8, 'nombre' => 'O-'],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('grupo_sanguineo');
    }
};
