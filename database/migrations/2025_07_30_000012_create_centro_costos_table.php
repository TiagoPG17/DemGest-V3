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
            ['id' => 1, 'codigo' => '10000', 'nombre' => 'Administración', 'created_at' => '2025-07-07 21:05:11', 'updated_at' => '2025-07-07 21:05:11'],
            ['id' => 2, 'codigo' => '10001', 'nombre' => 'Gerencia General', 'created_at' => '2025-07-07 21:05:11', 'updated_at' => '2025-07-07 21:05:11'],
            ['id' => 3, 'codigo' => '10002', 'nombre' => 'Gestion Humana', 'created_at' => '2025-07-07 21:05:11', 'updated_at' => '2025-07-07 21:05:11'],
            ['id' => 4, 'codigo' => '10003', 'nombre' => 'Gerencia Financiera', 'created_at' => '2025-07-07 21:05:11', 'updated_at' => '2025-07-07 21:05:11'],
            ['id' => 5, 'codigo' => '10004', 'nombre' => 'Dirección Contable', 'created_at' => '2025-07-07 21:05:11', 'updated_at' => '2025-07-07 21:05:11'],
            ['id' => 6, 'codigo' => '10005', 'nombre' => 'Dirección Sistemas', 'created_at' => '2025-07-07 21:05:11', 'updated_at' => '2025-07-07 21:05:11'],
            ['id' => 7, 'codigo' => '10006', 'nombre' => 'Nómina', 'created_at' => '2025-07-07 21:05:11', 'updated_at' => '2025-07-07 21:05:11'],
            ['id' => 8, 'codigo' => '10007', 'nombre' => 'Dirección de compras', 'created_at' => '2025-07-07 21:05:11', 'updated_at' => '2025-07-07 21:05:11'],
            ['id' => 9, 'codigo' => '20000', 'nombre' => 'Ventas', 'created_at' => '2025-07-07 21:05:11', 'updated_at' => '2025-07-07 21:05:11'],
            ['id' => 10, 'codigo' => '20001', 'nombre' => 'Comercial (Vendedores)', 'created_at' => '2025-07-07 21:05:11', 'updated_at' => '2025-07-07 21:05:11'],
            ['id' => 11, 'codigo' => '20002', 'nombre' => 'Despachos y bodega', 'created_at' => '2025-07-07 21:05:11', 'updated_at' => '2025-07-07 21:05:11'],
            ['id' => 12, 'codigo' => '30001', 'nombre' => 'Impresora NP1', 'created_at' => '2025-07-07 21:05:11', 'updated_at' => '2025-07-07 21:05:11'],
            ['id' => 13, 'codigo' => '30002', 'nombre' => 'Impresora NP2', 'created_at' => '2025-07-07 21:05:11', 'updated_at' => '2025-07-07 21:05:11'],
            ['id' => 14, 'codigo' => '30003', 'nombre' => 'Impresora NP3', 'created_at' => '2025-07-07 21:05:11', 'updated_at' => '2025-07-07 21:05:11'],
            ['id' => 15, 'codigo' => '30004', 'nombre' => 'Impresora Kopack', 'created_at' => '2025-07-07 21:05:11', 'updated_at' => '2025-07-07 21:05:11'],
            ['id' => 16, 'codigo' => '30005', 'nombre' => 'Mano de obra directa operarios (aux)', 'created_at' => '2025-07-07 21:05:11', 'updated_at' => '2025-07-07 21:05:11'],
            ['id' => 17, 'codigo' => '30006', 'nombre' => 'Mano de obra directa rebobinado', 'created_at' => '2025-07-07 21:05:11', 'updated_at' => '2025-07-07 21:05:11'],
            ['id' => 18, 'codigo' => '40000', 'nombre' => 'APOYO PRODUCCION', 'created_at' => '2025-07-07 21:05:11', 'updated_at' => '2025-07-07 21:05:11'],
            ['id' => 19, 'codigo' => '40001', 'nombre' => 'Gerencia de planta', 'created_at' => '2025-07-07 21:05:11', 'updated_at' => '2025-07-07 21:05:11'],
            ['id' => 20, 'codigo' => '40003', 'nombre' => 'Mantenimiento', 'created_at' => '2025-07-07 21:05:11', 'updated_at' => '2025-07-07 21:05:11'],
            ['id' => 21, 'codigo' => '40004', 'nombre' => 'Laboratorio', 'created_at' => '2025-07-07 21:05:11', 'updated_at' => '2025-07-07 21:05:11'],
            ['id' => 22, 'codigo' => '40005', 'nombre' => 'Preprensa digital', 'created_at' => '2025-07-07 21:05:11', 'updated_at' => '2025-07-07 21:05:11'],
            ['id' => 23, 'codigo' => '40006', 'nombre' => 'Calidad', 'created_at' => '2025-07-07 21:05:11', 'updated_at' => '2025-07-07 21:05:11'],
            ['id' => 24, 'codigo' => '40007', 'nombre' => 'Programacion', 'created_at' => '2025-07-07 21:05:11', 'updated_at' => '2025-07-07 21:05:11'],
            ['id' => 25, 'codigo' => '40009', 'nombre' => 'Tintas', 'created_at' => '2025-07-07 21:05:11', 'updated_at' => '2025-07-07 21:05:11'],
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
