<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    // Créer un utilisateur administrateur par défaut
    {
        User::create([
            'nom' => 'tasnime',
            'email' => 'eljedtasnime5@gemail.com',
            'password' => Hash::make('azertyui'),
            'role' => 'admin',
        ]);
    }
}
