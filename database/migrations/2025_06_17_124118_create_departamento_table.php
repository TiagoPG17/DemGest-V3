<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDepartamentoTable extends Migration
{
    public function up()
    {
        Schema::create('departamento', function (Blueprint $table) {
            $table->id('id_departamento');
            $table->string('nombre_departamento', 100)->nullable();
            $table->bigInteger('pais_id')->unsigned()->nullable()->index();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();

            $table->foreign('pais_id')->references('id')->on('pais')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::dropIfExists('departamento');
    }
}