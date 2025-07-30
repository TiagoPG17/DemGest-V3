<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('afp', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 100);
        });

        // Insertar datos iniciales
        DB::table('afp')->insert([
            ['nombre' => 'Protección'],
            ['nombre' => 'Porvenir'],
            ['nombre' => 'Colfondos'],
            ['nombre' => 'Old Mutual'],
        ]);
    }

    public function down()
    {
        Schema::dropIfExists('afp');
    }
};
