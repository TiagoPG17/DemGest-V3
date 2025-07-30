<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('estado_cargo', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('estado_id');
            $table->unsignedBigInteger('cargo_id');
            $table->unsignedBigInteger('centro_costo_id');
            $table->timestamps();

            // Claves foráneas
            $table->foreign('estado_id')->references('id_estado')->on('informacion_laboral');
            $table->foreign('cargo_id')->references('id_cargo')->on('cargos');
            $table->foreign('centro_costo_id')->references('id')->on('centro_costos');
        });
    }

    public function down()
    {
        Schema::dropIfExists('estado_cargo');
    }
};