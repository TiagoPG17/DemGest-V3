<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('bancos', function (Blueprint $table) {
            $table->id('id_banco');
            $table->string('nombre_banco', 100);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('bancos');
    }
};
