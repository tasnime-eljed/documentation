<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Cette méthode crée la table 'projects' dans la base de données
     */
    public function up(): void
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id(); // Clé primaire auto-incrémentée 'id'

            $table->string('nom'); // Nom du projet (VARCHAR 255)

            $table->text('description')->nullable();
            // Description du projet, peut être vide (NULL)

            $table->foreignId('user_id')
                  ->constrained()
                  // Crée une clé étrangère vers 'id' de la table 'users'
                  ->onDelete('cascade');
                  // Si l'utilisateur est supprimé, tous ses projets le sont aussi

            $table->timestamps();
            // Crée 'created_at' et 'updated_at' automatiquement
        });
    }

    /**
     * Reverse the migrations.
     * Cette méthode supprime la table 'projects' si la migration est annulée
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
