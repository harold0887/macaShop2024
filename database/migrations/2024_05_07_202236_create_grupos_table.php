<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('grupos', function (Blueprint $table) {
            $table->id();
            $table->string('escuela');
            $table->string('grado_grupo');
            $table->string('cliclo_escolar');
            $table->string('materia')->nullable();
            $table->string('maestro')->nullable();
            $table->string('color');
            $table->boolean('oculto')->default('0');
            $table->BigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->restrictOnDelete()->restrictOnUpdate();
            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        Schema::dropIfExists('grupos');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
};
