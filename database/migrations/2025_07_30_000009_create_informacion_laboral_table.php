<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('informacion_laboral', function (Blueprint $table) {
            $table->unsignedBigInteger('id_estado')->primary();
            $table->unsignedBigInteger('empleado_id');
            $table->unsignedBigInteger('empresa_id');
            $table->date('fecha_ingreso')->nullable();
            $table->date('fecha_salida')->nullable();
            $table->unsignedInteger('cantidad_prorroga')->default(0);
            $table->unsignedInteger('duracion_prorrogas')->nullable();
            $table->dateTime('fecha_prorroga')->nullable();
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->string('tipo_contrato', 50)->nullable();
            $table->text('observaciones')->nullable();
            $table->string('ubicacion_fisica', 150)->nullable();
            $table->integer('ciudad_laboral_id')->nullable();
            $table->boolean('aplica_dotacion')->nullable();
            $table->string('talla_camisa', 10)->nullable();
            $table->string('talla_pantalon', 10)->nullable();
            $table->string('talla_zapatos', 10)->nullable();
            $table->string('relacion_laboral', 255)->nullable()->comment('Relación laboral actual');
            $table->boolean('relacion_sindical')->nullable()->comment('1 = Sí, 0 = No');
            $table->enum('tipo_vinculacion', ['Directo', 'Indirecto'])->default('Directo');

            // Índices y claves foráneas
            $table->foreign('empleado_id')
                ->references('id_empleado')
                ->on('empleados')
                ->onDelete('cascade');
                
            $table->foreign('empresa_id')
                ->references('id_empresa')
                ->on('empresa')
                ->onDelete('cascade');
                
            // Índice para ciudad_laboral_id (la tabla ciudades_laborales se creará después)
            $table->index('ciudad_laboral_id', 'informacion_laboral_ciudad_laboral_id_index');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('informacion_laboral');
    }
};
