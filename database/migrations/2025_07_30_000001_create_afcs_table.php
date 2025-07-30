<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('afcs', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 100);
            $table->timestamps();
        });

        // Insertar datos iniciales
        DB::table('afcs')->insert([
            ['nombre' => 'COLFONDOS', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'FONDO NACIONAL DEL AHORRO', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'PORVENIR', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'PROTECCIÓN', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    public function down()
    {
        Schema::dropIfExists('afcs');
    }
};
