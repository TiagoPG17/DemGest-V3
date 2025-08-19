<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePatologiaTable extends Migration
{
    public function up()
    {
        Schema::create('patologia', function (Blueprint $table) {
            $table->id('id_patologia');
            $table->string('nombre_patologia', 255)->nullable();
            $table->dateTime('fecha_actual_patologia')->nullable();
            $table->text('tratamiento_actual_patologia')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
        });
    }

    public function down()
    {
        Schema::dropIfExists('patologia');
    }
}