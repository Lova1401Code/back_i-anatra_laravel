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
        Schema::table('eleves', function (Blueprint $table) {
            // Ajout des nouvelles colonnes
            // $table->foreignId('classe_id')->nullable()->constrained('classes');
            // $table->dropForeign('classe_id')->constrained('classes');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
    }
};
