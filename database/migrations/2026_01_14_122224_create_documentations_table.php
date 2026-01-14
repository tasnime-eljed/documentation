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
        Schema::create('documentations', function (Blueprint $table) {
            $table->id();
            $table->string('titre');
            $table->longText('contenu');
            $table->integer('temps_lecture')->default(0)->comment('Temps de lecture en minutes');
            $table->integer('vues')->default(0);
            $table->foreignId('categoryId')->constrained('categories')->onDelete('cascade');
            $table->foreignId('userId')->constrained('users')->onDelete('cascade');
            $table->timestamps();

            // Index pour améliorer les performances
            $table->index('titre');
            $table->index('vues');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('documentations');
    }
};
