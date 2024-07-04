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
        Schema::create('annees_scolaires', function (Blueprint $table) {
            $table->id();
            $table->string('annee'); // par exemple, '2023-2024'
            $table->date('debut');
            $table->date('fin');
            $table->string('statut');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('annees_scolaires');
    }
};
