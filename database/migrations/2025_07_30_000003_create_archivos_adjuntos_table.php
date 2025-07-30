<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('archivos_adjuntos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('empleado_id');
            $table->unsignedBigInteger('beneficiario_id')->nullable();
            $table->string('nombre', 255);
            $table->string('ruta', 255);
            $table->string('tipo', 100)->nullable();
            $table->timestamps();

            // Claves foráneas
            $table->foreign('empleado_id')
                  ->references('id_empleado')
                  ->on('empleados')
                  ->onDelete('cascade');
                  
            $table->foreign('beneficiario_id')
                  ->references('id_beneficiario')
                  ->on('beneficiarios')
                  ->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::dropIfExists('archivos_adjuntos');
    }
};
