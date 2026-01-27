<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Cette méthode crée la table `shared_links`.
     */
    public function up(): void
    {
        Schema::create('shared_links', function (Blueprint $table) {
            $table->id(); // Clé primaire auto-incrémentée
            $table->foreignId('documentation_id') // Clé étrangère vers la documentation partagée
                  ->constrained('documentations')
                  ->onDelete('cascade'); // Supprime le lien si la documentation est supprimée
            $table->string('token', 64)->unique();
            // Jeton unique pour accéder au document via lien partagé
            $table->timestamp('date_creation')->useCurrent();
            // Date de création du lien, automatiquement à l'heure actuelle
            $table->timestamps(); // created_at et updated_at

            // Index pour accélérer la recherche par token (recherche rapide)
            $table->index('token');
        });
    }

    /**
     * Reverse the migrations.
     * Cette méthode supprime la table `shared_links`.
     */
    public function down(): void
    {
        Schema::dropIfExists('shared_links');
    }
};
