<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBeneficiariosTable extends Migration
{
    public function up()
    {
        Schema::create('beneficiarios', function (Blueprint $table) {
            $table->id('id_beneficiarios');
            $table->bigInteger('empleado_id')->unsigned()->nullable()->index();
            $table->string('nombre_beneficiario', 255)->nullable();
            $table->string('parentesco_varchar', 50)->nullable();
            $table->date('fecha_nacimiento')->nullable();
            $table->string('tipo_documento', 50)->nullable();
            $table->string('numero_documento', 50)->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();

            $table->foreign('empleado_id')->references('id')->on('empleados')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::dropIfExists('beneficiarios');
    }
}