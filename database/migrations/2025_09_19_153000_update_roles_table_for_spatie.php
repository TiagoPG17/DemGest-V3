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
        Schema::table('roles', function (Blueprint $table) {
            // Agregar columnas necesarias para Spatie Permission
            if (!Schema::hasColumn('roles', 'guard_name')) {
                $table->string('guard_name')->default('web');
            }
            if (!Schema::hasColumn('roles', 'created_at')) {
                $table->timestamp('created_at')->nullable();
            }
            if (!Schema::hasColumn('roles', 'updated_at')) {
                $table->timestamp('updated_at')->nullable();
            }
        });

        Schema::table('permissions', function (Blueprint $table) {
            // Agregar columnas necesarias para Spatie Permission
            if (!Schema::hasColumn('permissions', 'guard_name')) {
                $table->string('guard_name')->default('web');
            }
            if (!Schema::hasColumn('permissions', 'created_at')) {
                $table->timestamp('created_at')->nullable();
            }
            if (!Schema::hasColumn('permissions', 'updated_at')) {
                $table->timestamp('updated_at')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('roles', function (Blueprint $table) {
            $table->dropColumn(['guard_name', 'created_at', 'updated_at']);
        });

        Schema::table('permissions', function (Blueprint $table) {
            $table->dropColumn(['guard_name', 'created_at', 'updated_at']);
        });
    }
};
