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
        Schema::create('dia_estudiante', function (Blueprint $table) {
            $table->id();
            $table->foreignId('dia_id')->references('id')->on('dias')->constrained()->cascadeOnDelete();
            $table->foreignId('estudiante_id')->references('id')->on('estudiantes')->constrained()->cascadeOnDelete();
            $table->unique(array('dia_id', 'estudiante_id'));
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dia_estudiante');
    }
};
