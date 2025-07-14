<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMunicipioTable extends Migration
{
    public function up()
    {
        Schema::create('municipio', function (Blueprint $table) {
            $table->id();
            $table->string('nombre_municipio', 255)->nullable();
            $table->bigInteger('departamento_id')->unsigned()->nullable()->index();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();

            $table->foreign('departamento_id')->references('id')->on('departamento')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::dropIfExists('municipio');
    }
}