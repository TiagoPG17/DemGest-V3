<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('eps', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 100);
            $table->timestamps();
        });

        // Insertar datos iniciales
        DB::table('eps')->insert([
            ['nombre' => 'Sura'],
            ['nombre' => 'Sanitas'],
            ['nombre' => 'Nueva EPS'],
            ['nombre' => 'Compensar'],
            ['nombre' => 'Cafesalud']
        ]);
    }

    public function down()
    {
        Schema::dropIfExists('eps');
    }
};