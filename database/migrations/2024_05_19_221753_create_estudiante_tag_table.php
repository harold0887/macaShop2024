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
        Schema::create('estudiante_tag', function (Blueprint $table) {
            $table->id();
            $table->date('dia');
            $table->foreignId('tag_id')->references('id')->on('tags')->constrained()->cascadeOnDelete();
            $table->foreignId('estudiante_id')->references('id')->on('estudiantes')->constrained()->cascadeOnDelete();
            $table->unique(array('tag_id', 'estudiante_id', 'dia'));
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('estudiante_tag');
    }
};
