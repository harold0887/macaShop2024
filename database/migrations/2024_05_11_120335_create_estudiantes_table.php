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
        Schema::create('estudiantes', function (Blueprint $table) {
            $table->id();
            $table->string('apellidos');
            $table->string('nombres');
            $table->date('fecha_nacimiento');
            $table->string('genero');
            $table->string('imagen')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('phone2')->nullable();
            $table->mediumText('comentarios')->nullable();
            $table->BigInteger('user_id');
            $table->foreignId('grupo_id')->references('id')->on('grupos')->constrained()->cascadeOnDelete();
            //$table->foreign('user_id')->references('id')->on('users')->restrictOnDelete()->restrictOnUpdate();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        Schema::dropIfExists('estudiantes');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
};
