<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void //pour creer/modifier une table
    {
        Schema::create('users', function (Blueprint $table)
        //Blueprint $table → objet pour définir les colonnes.
        {
            $table->id();
            $table->string('nom');
            $table->string('email')->unique();
            $table->string('password');
            $table->enum('role', ['admin', 'reader'])->default('reader'); // cohérence avec middleware
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations. annuler les migrations
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
