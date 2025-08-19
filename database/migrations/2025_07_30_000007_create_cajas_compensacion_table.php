<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('cajas_compensacion', function (Blueprint $table) {
            $table->id('id_caja_compensacion');
            $table->string('nombre_caja_compensacion', 100);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('cajas_compensacion');
    }
};
