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
        Schema::create('paiements', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('eleve_id');
            $table->unsignedBigInteger('annee_scolaire_id');
            $table->decimal('montant', 10, 2);
            $table->string('methode_paiement'); // ex: 'carte', 'virement', 'especes'
            $table->date('date_paiement');
            $table->timestamps();
            $table->foreign('eleve_id')->references('id')->on('eleves')->onDelete('cascade');
            $table->foreign('annee_scolaire_id')->references('id')->on('annees_scolaires')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('paiements');
    }
};
