<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Crée la table 'documentations'
     */
    public function up(): void
    {
        Schema::create('documentations', function (Blueprint $table) {
            $table->id(); // clé primaire auto-incrémentée
            $table->string('titre'); // titre de la documentation
            $table->longText('contenu'); // contenu complet
            $table->integer('temps_lecture')->default(0)->comment('Temps de lecture en minutes');
            $table->integer('vues')->default(0); // nombre de vues
            $table->foreignId('category_id') // référence à la catégorie
                  ->constrained('categories') // table parent
                  ->onDelete('cascade'); // supprime les docs si catégorie supprimée
            $table->foreignId('user_id') // référence à l'utilisateur (auteur)
                  ->constrained('users')
                  ->onDelete('cascade'); // supprime les docs si utilisateur supprimé
            $table->timestamps(); // created_at et updated_at

            // Index pour améliorer les performances sur la recherche par titre et tri par vues
            $table->index('titre');
            $table->index('vues');
        });
    }

    /**
     * Reverse the migrations.
     * Supprime la table 'documentations'
     */
    public function down(): void
    {
        Schema::dropIfExists('documentations');
    }
};
