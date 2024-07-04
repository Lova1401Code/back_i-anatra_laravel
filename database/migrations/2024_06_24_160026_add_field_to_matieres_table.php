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
            $table->float('note_interro1')->nullable();
            $table->float('note_interro2')->nullable();
            $table->float('note_examen')->nullable();
            // Supprimer le champ note
            $table->dropColumn('note');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('notes', function (Blueprint $table) {
            $table->dropColumn(['note_interro1', 'note_interro2', 'note_examen']);
        });
    }
};
