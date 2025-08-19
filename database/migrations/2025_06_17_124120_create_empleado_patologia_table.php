<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmpleadoPatologiaTable extends Migration
{
    public function up()
    {
        Schema::create('empleado_patologia', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('empleado_id')->unsigned()->nullable()->index();
            $table->bigInteger('patologia_id')->unsigned()->nullable()->index();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();

            $table->foreign('empleado_id')->references('id')->on('empleados')->onDelete('set null');
            $table->foreign('patologia_id')->references('id')->on('patologia')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::dropIfExists('empleado_patologia');
    }
}