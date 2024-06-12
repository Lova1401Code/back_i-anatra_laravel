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
        Schema::create('matiere_eleve', function (Blueprint $table) {
            $table->id();
            $table->foreignId('matiere_id')->constrained('matieres')->onDelete('cascade');
            $table->foreignId('eleve_id')->constrained('eleves')->onDelete('cascade');
            $table->decimal('note', 5, 2); // Note associée pour déterminer les meilleurs élèves
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('matiere_eleve');
    }
};
