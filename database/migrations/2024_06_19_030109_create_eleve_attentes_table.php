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
        Schema::create('eleve_attentes', function (Blueprint $table) {
            $table->id();
            $table->string('matricule')->unique();
            $table->string('nom');
            $table->string('prenom');
            $table->string('email')->unique();
            $table->date('date_naissance');
            $table->string('photo_profil')->nullable();
            $table->string('pere_nom')->nullable();
            $table->string('pere_prenom')->nullable();
            $table->string('profession_pere')->nullable();
            $table->string('pere_contact')->nullable();
            $table->string('mere_nom')->nullable();
            $table->string('mere_prenom')->nullable();
            $table->string('profession_mere')->nullable();
            $table->string('mere_contact')->nullable();
            $table->string('emailParent')->unique();
            $table->string('tuteur_nom')->nullable();
            $table->string('tuteur_prenom')->nullable();
            $table->string('tuteur_contact')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('eleves_attentes');
    }
};
