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
        Schema::table('matieres', function (Blueprint $table) {
            // Ajout des nouvelles colonnes
            $table->foreignId('semestre_id')->nullable()->constrained('semestres')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('matieres', function (Blueprint $table) {
            // Suppression des nouvelles colonnes
            $table->dropForeign(['semestre_id']);
            $table->dropColumn('semestre_id');
        });
    }
};
