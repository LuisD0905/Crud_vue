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
        Schema::create('persona', function (Blueprint $table) {
            $table -> id();
            $table -> string('nombre');
            $table -> string('apellido');
            $table -> string('nacionalidad');
            $table -> integer('edad');
            $table -> date('fecha_nacimiento');
            $table -> string('nombre_padre');
            $table -> string('cedula_padre');
            $table -> string('nombre_madre');
            $table -> string('cedula_madre');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('persona');
    }
};
