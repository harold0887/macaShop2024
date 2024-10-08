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
        Schema::create('asistencias', function (Blueprint $table) {
            $table->id();
            $table->date('dia');
            $table->foreignId('status_id')->references('id')->on('status')->constrained()->restrictOnDelete();
            $table->foreignId('estudiante_id')->references('id')->on('estudiantes')->constrained()->cascadeOnDelete();
            $table->unique(array('dia', 'estudiante_id'));
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('asistencias');
    }
};
