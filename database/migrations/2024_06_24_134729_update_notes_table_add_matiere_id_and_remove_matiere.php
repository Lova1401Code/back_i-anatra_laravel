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
        Schema::table('notes', function (Blueprint $table) {
            // Ajouter le champ matiere_id
            $table->foreignId('matiere_id')->constrained('matieres')->onDelete('cascade')->after('eleve_id');
            $table->string('commentaire');
            $table->date('date');
            // Supprimer le champ matiere
            $table->dropColumn('matiere');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('notes', function (Blueprint $table) {
            // Restaurer le champ matiere
            $table->string('matiere')->after('eleve_id');

            // Supprimer le champ matiere_id
            $table->dropForeign(['matiere_id']);
            $table->dropColumn('matiere_id');
        });
    }
};
