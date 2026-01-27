<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Crée la table 'categories' avec ses colonnes et relations.
     */
    public function up(): void
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id(); // Clé primaire auto-incrémentée
            $table->string('nom'); // Nom de la catégorie
            $table->foreignId('project_id') // Clé étrangère vers la table 'projects'
                  ->constrained('projects') // Lie project_id à l'id de projects 'projects':nom de la table référencée
                  ->onDelete('cascade'); // Supprime les catégories si le projet parent est supprimé
            $table->timestamps(); // created_at et updated_at
        });
    }

    /**
     * Reverse the migrations.
     * Supprime la table 'categories' si elle existe.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
