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
        Schema::create('favoris', function (Blueprint $table) {
            $table->id();
            $table->foreignId('userId')->constrained('users')->onDelete('cascade');
            $table->foreignId('docId')->constrained('documentations')->onDelete('cascade');
            $table->timestamps();

            // Contrainte unique pour éviter les doublons
            $table->unique(['userId', 'docId']);

            // Index pour améliorer les performances des requêtes
            $table->index('userId');
            $table->index('docId');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('favoris');
    }
};
