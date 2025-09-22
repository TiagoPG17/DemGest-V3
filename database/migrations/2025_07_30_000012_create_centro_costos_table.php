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
        Schema::create('centro_costos', function (Blueprint $table) {
            $table->id();
            $table->string('codigo', 20)->unique();
            $table->string('nombre', 100);
            $table->timestamps();
        });

        // Insertar datos iniciales
        \DB::table('centro_costos')->insert([
            // Centros de costo Contiflex (CX_) - Administrativos y generales
            ['id' => 1, 'codigo' => 'CX_10000', 'nombre' => 'Administración', 'created_at' => '2025-07-07 21:05:11', 'updated_at' => '2025-07-07 21:05:11'],
            ['id' => 2, 'codigo' => 'CX_10001', 'nombre' => 'Gerencia General', 'created_at' => '2025-07-07 21:05:11', 'updated_at' => '2025-07-07 21:05:11'],
            ['id' => 3, 'codigo' => 'CX_10002', 'nombre' => 'Gestion Humana', 'created_at' => '2025-07-07 21:05:11', 'updated_at' => '2025-07-07 21:05:11'],
            ['id' => 4, 'codigo' => 'CX_10003', 'nombre' => 'Gerencia Financiera', 'created_at' => '2025-07-07 21:05:11', 'updated_at' => '2025-07-07 21:05:11'],
            ['id' => 5, 'codigo' => 'CX_10004', 'nombre' => 'Dirección Contable', 'created_at' => '2025-07-07 21:05:11', 'updated_at' => '2025-07-07 21:05:11'],
            ['id' => 6, 'codigo' => 'CX_10005', 'nombre' => 'Dirección Sistemas', 'created_at' => '2025-07-07 21:05:11', 'updated_at' => '2025-07-07 21:05:11'],
            ['id' => 7, 'codigo' => 'CX_10006', 'nombre' => 'Nómina', 'created_at' => '2025-07-07 21:05:11', 'updated_at' => '2025-07-07 21:05:11'],
            ['id' => 8, 'codigo' => 'CX_10007', 'nombre' => 'Dirección de compras', 'created_at' => '2025-07-07 21:05:11', 'updated_at' => '2025-07-07 21:05:11'],
            ['id' => 9, 'codigo' => 'CX_20000', 'nombre' => 'Ventas', 'created_at' => '2025-07-07 21:05:11', 'updated_at' => '2025-07-07 21:05:11'],
            ['id' => 10, 'codigo' => 'CX_20001', 'nombre' => 'Comercial (Vendedores)', 'created_at' => '2025-07-07 21:05:11', 'updated_at' => '2025-07-07 21:05:11'],
            ['id' => 11, 'codigo' => 'CX_20002', 'nombre' => 'Despachos y bodega', 'created_at' => '2025-07-07 21:05:11', 'updated_at' => '2025-07-07 21:05:11'],
            
            // Centros de costo Formacol (FC_) - Producción y operativos
            ['id' => 12, 'codigo' => 'FC_30001', 'nombre' => 'Impresora NP1', 'created_at' => '2025-07-07 21:05:11', 'updated_at' => '2025-07-07 21:05:11'],
            ['id' => 13, 'codigo' => 'FC_30002', 'nombre' => 'Impresora NP2', 'created_at' => '2025-07-07 21:05:11', 'updated_at' => '2025-07-07 21:05:11'],
            ['id' => 14, 'codigo' => 'FC_30003', 'nombre' => 'Impresora NP3', 'created_at' => '2025-07-07 21:05:11', 'updated_at' => '2025-07-07 21:05:11'],
            ['id' => 15, 'codigo' => 'FC_30004', 'nombre' => 'Impresora Kopack', 'created_at' => '2025-07-07 21:05:11', 'updated_at' => '2025-07-07 21:05:11'],
            ['id' => 16, 'codigo' => 'FC_30005', 'nombre' => 'Mano de obra directa operarios (aux)', 'created_at' => '2025-07-07 21:05:11', 'updated_at' => '2025-07-07 21:05:11'],
            ['id' => 17, 'codigo' => 'FC_30006', 'nombre' => 'Mano de obra directa rebobinado', 'created_at' => '2025-07-07 21:05:11', 'updated_at' => '2025-07-07 21:05:11'],
            ['id' => 18, 'codigo' => 'FC_40000', 'nombre' => 'APOYO PRODUCCION', 'created_at' => '2025-07-07 21:05:11', 'updated_at' => '2025-07-07 21:05:11'],
            ['id' => 19, 'codigo' => 'FC_40001', 'nombre' => 'Gerencia de planta', 'created_at' => '2025-07-07 21:05:11', 'updated_at' => '2025-07-07 21:05:11'],
            ['id' => 20, 'codigo' => 'FC_40003', 'nombre' => 'Mantenimiento', 'created_at' => '2025-07-07 21:05:11', 'updated_at' => '2025-07-07 21:05:11'],
            ['id' => 21, 'codigo' => 'FC_40004', 'nombre' => 'Laboratorio', 'created_at' => '2025-07-07 21:05:11', 'updated_at' => '2025-07-07 21:05:11'],
            ['id' => 22, 'codigo' => 'FC_40005', 'nombre' => 'Preprensa digital', 'created_at' => '2025-07-07 21:05:11', 'updated_at' => '2025-07-07 21:05:11'],
            ['id' => 23, 'codigo' => 'FC_40006', 'nombre' => 'Calidad', 'created_at' => '2025-07-07 21:05:11', 'updated_at' => '2025-07-07 21:05:11'],
            ['id' => 24, 'codigo' => 'FC_40007', 'nombre' => 'Programacion', 'created_at' => '2025-07-07 21:05:11', 'updated_at' => '2025-07-07 21:05:11'],
            ['id' => 25, 'codigo' => 'FC_40009', 'nombre' => 'Tintas', 'created_at' => '2025-07-07 21:05:11', 'updated_at' => '2025-07-07 21:05:11'],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('centro_costos');
    }
};
