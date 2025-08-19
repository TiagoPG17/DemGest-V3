<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmpleadoPaisUbicacionTable extends Migration
{
    public function up()
    {
        Schema::create('empleado_pais_ubicacion', function (Blueprint $table) {
            $table->id('id_empleado_pais_ubicacion');
            $table->bigInteger('empleado_id')->unsigned()->nullable()->index();
            $table->bigInteger('pais_id')->unsigned()->nullable()->index();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();

            $table->foreign('empleado_id')->references('id')->on('empleados')->onDelete('set null');
            $table->foreign('pais_id')->references('id')->on('pais')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::dropIfExists('empleado_pais_ubicacion');
    }
}