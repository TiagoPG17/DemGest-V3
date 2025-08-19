<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmpleadosTable extends Migration
{
    public function up()
	{
    Schema::create('empleados', function (Blueprint $table) {
        $table->bigIncrements('id');
        $table->string('tipo_documento', 50)->nullable();
        $table->string('numero_documento', 50)->nullable();
        $table->string('nombre_completo', 255)->nullable();
        $table->date('fecha_nacimiento')->nullable();
        $table->string('sexo', 50)->nullable();
        $table->string('direccion', 255)->nullable();
        $table->string('telefono', 50)->nullable();
        $table->string('email', 255)->nullable();
        $table->bigInteger('estado_id')->unsigned()->nullable();
        $table->timestamps();

    	  });
	}

    public function down()
    {
        Schema::dropIfExists('empleados');
    }
}

