<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Cette méthode crée la table `sessions` pour stocker les sessions utilisateur.
     */
    public function up(): void
    {
        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            // ID unique de la session (clé primaire, non auto-incrémentée)

            $table->foreignId('user_id')->nullable()->index();
            // ID de l'utilisateur lié à cette session (nullable car la session peut être publique)
            // Index pour accélérer les recherches par utilisateur

            $table->string('ip_address', 45)->nullable();
            // Adresse IP de l'utilisateur (IPv4 ou IPv6)

            $table->text('user_agent')->nullable();
            // Informations sur le navigateur / client

            $table->longText('payload');
            // Données de session sérialisées

            $table->integer('last_activity')->index();
            // Timestamp de la dernière activité (index pour les nettoyages ou recherches rapides)
        });
    }

    /**
     * Reverse the migrations.
     * Cette méthode supprime la table `sessions`.
     */
    public function down(): void
    {
        Schema::dropIfExists('sessions');
    }
};
