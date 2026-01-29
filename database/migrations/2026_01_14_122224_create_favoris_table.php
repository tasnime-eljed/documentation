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
        Schema::create('favorites', function (Blueprint $table) {
            $table->id(); // ID auto-incrémenté
            $table->foreignId('user_id') // ID de l'utilisateur
                  ->constrained('users') // clé étrangère vers table 'users'
                  ->onDelete('cascade'); // suppression en cascade si l'utilisateur est supprimé
              // pour pouvoir liker des Projets OU des Docs
            $table->morphs('favoritable');

            $table->timestamps();

            // Empêcher les doublons (un user ne peut pas liker 2 fois le même objet)
            $table->unique(['user_id', 'favoritable_id', 'favoritable_type']);

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
