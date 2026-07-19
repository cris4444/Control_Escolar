<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('Permisos', function (Blueprint $table) {
            $table->id();
            $table->string('clave', 60)->unique(); // ej. 'usuarios.crear'
            $table->string('modulo', 40);           // ej. 'usuarios' (para agrupar en la vista)
            $table->string('descripcion', 150)->nullable();
        });

        Schema::create('rol_permiso', function (Blueprint $table) {
            $table->foreignId('rol_id')->constrained('Roles')->cascadeOnDelete();
            $table->foreignId('permiso_id')->constrained('Permisos')->cascadeOnDelete();
            $table->primary(['rol_id', 'permiso_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rol_permiso');
        Schema::dropIfExists('Permisos');
    }
};
