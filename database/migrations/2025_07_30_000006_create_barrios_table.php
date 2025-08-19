<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('barrios', function (Blueprint $table) {
            $table->id('id_barrio');
            $table->string('nombre_barrio', 100);
            $table->unsignedBigInteger('id_municipio');
            $table->timestamps();
            
            // Clave foránea
            $table->foreign('id_municipio')
                  ->references('id_municipio')
                  ->on('municipios')
                  ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('barrios');
    }
};
