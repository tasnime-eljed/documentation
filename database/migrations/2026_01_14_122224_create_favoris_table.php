<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Cette méthode crée la table 'favoris' pour gérer les favoris des utilisateurs.
     */
    public function up(): void
    {
        Schema::create('favoris', function (Blueprint $table) {
            $table->id(); // ID auto-incrémenté
            $table->foreignId('user_id') // ID de l'utilisateur
                  ->constrained('users') // clé étrangère vers table 'users'
                  ->onDelete('cascade'); // suppression en cascade si l'utilisateur est supprimé
            $table->foreignId('documentation_id') // ID de la documentation
                  ->constrained('documentations') // clé étrangère vers table 'documentations'
                  ->onDelete('cascade'); // suppression en cascade si la doc est supprimée
            $table->timestamps(); // created_at et updated_at

            // Contrainte unique pour empêcher un utilisateur de mettre le même document en favoris plusieurs fois
            $table->unique(['user_id', 'documentation_id']);

            // Index pour améliorer les performances des requêtes fréquentes
            $table->index('user_id'); // rapide pour chercher tous les favoris d'un utilisateur
            $table->index('documentation_id'); // rapide pour vérifier si une doc est dans les favoris
        });
    }

    /**
     * Reverse the migrations.
     * Supprime la table 'favoris' si on rollback la migration.
     */
    public function down(): void
    {
        Schema::dropIfExists('favoris');
    }
};
