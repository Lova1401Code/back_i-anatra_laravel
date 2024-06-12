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
        Schema::create('admissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('eleve_id')->constrained('eleves')->onDelete('cascade');
            $table->foreignId('annee_scolaire_id')->constrained('annees_scolaires')->onDelete('cascade');
            $table->string('statut'); // par exemple, 'admis', 'en attente', 'rejeté'
            $table->date('date_admission');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admissions');
    }
};
