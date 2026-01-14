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
        Schema::create('shared_links', function (Blueprint $table) {
            $table->id();
            $table->foreignId('docId')->constrained('documentations')->onDelete('cascade');
            $table->string('token', 64)->unique();
            $table->timestamp('date_creation')->useCurrent();
            $table->timestamps();

            // Index pour recherche rapide par token
            $table->index('token');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shared_links');
    }
};
