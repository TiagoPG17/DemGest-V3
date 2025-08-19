<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('cargos', function (Blueprint $table) {
            $table->id('id_cargo');
            $table->string('nombre_cargo', 100);
            $table->unsignedBigInteger('id_dependencia');
            $table->timestamps();
            
            // Clave foránea
            $table->foreign('id_dependencia')
                  ->references('id_dependencia')
                  ->on('dependencias')
                  ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('cargos');
    }
};
