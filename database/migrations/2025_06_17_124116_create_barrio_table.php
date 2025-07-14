<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBarrioTable extends Migration
{
    public function up()
    {
        Schema::create('barrio', function (Blueprint $table) {
            $table->id();
            $table->string('nombre_barrio', 255)->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
            // Añade más columnas si las tienes en tu tabla original
        });
    }

    public function down()
    {
        Schema::dropIfExists('barrio');
    }
}