<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRangoEdadTable extends Migration
{
    public function up()
    {
        Schema::create('rango_edad', function (Blueprint $table) {
            $table->id();
            $table->string('nombre_rango', 255)->nullable();
            $table->integer('edad_minima')->nullable();
            $table->integer('edad_maxima')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
        });
    }

    public function down()
    {
        Schema::dropIfExists('rango_edad');
    }
}