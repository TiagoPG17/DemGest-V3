
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
        Schema::create('etnias', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 100);
            $table->timestamps();
        });

        // Insertar datos iniciales
        \DB::table('etnias')->insert([
            ['id' => 1, 'nombre' => 'Indígena', 'created_at' => null, 'updated_at' => null],
            ['id' => 2, 'nombre' => 'Rom (Gitano)', 'created_at' => null, 'updated_at' => null],
            ['id' => 3, 'nombre' => 'Raizal del Archipiélago de San Andrés', 'created_at' => null, 'updated_at' => null],
            ['id' => 4, 'nombre' => 'Palenquero de San Basilio', 'created_at' => null, 'updated_at' => null],
            ['id' => 5, 'nombre' => 'Afrocolombiano', 'created_at' => null, 'updated_at' => null],
            ['id' => 6, 'nombre' => 'Negro', 'created_at' => null, 'updated_at' => null],
            ['id' => 7, 'nombre' => 'Mulato', 'created_at' => null, 'updated_at' => null],
            ['id' => 8, 'nombre' => 'Mestizo', 'created_at' => null, 'updated_at' => null],
            ['id' => 9, 'nombre' => 'Blanco', 'created_at' => null, 'updated_at' => null],
            ['id' => 10, 'nombre' => 'Otro', 'created_at' => null, 'updated_at' => null],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('etnias');
    }
};
