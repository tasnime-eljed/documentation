<?php

namespace App\Http\Controllers\Reader;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Project;
use App\Models\Documentation;
use App\Models\Favorite;

class DashboardController extends Controller
{
    /**
     * Afficher le tableau de bord du Lecteur (Reader).
     */
    public function index()
    {
        // 1. Récupérer l'utilisateur connecté
        $user = Auth::user();

        // 2. Statistiques pour les cartes du haut
        // Comme on n'a pas d'historique de lecture, on affiche le total des docs disponibles
        $docsLus = Documentation::count();

        // Nombre de favoris de l'utilisateur
        $favorisCount = $user->favorites()->count();

        // Nombre total de projets disponibles
        $projetsCount = Project::count();

        // 3. Récupérer les 6 dernières documentations ajoutées
        // On charge la relation 'category' pour l'afficher dans la carte
        $recentDocs = Documentation::with('category')
                                   ->latest() // Trier par date de création (décroissant)
                                   ->take(6)  // Prendre les 6 derniers
                                   ->get();

        // 4. Récupérer les 4 derniers favoris de l'utilisateur
        // On charge 'favoritable' pour savoir si c'est un Projet ou une Doc
        $favoris = $user->favorites()
                        ->with('favoritable') // Eager Loading du polymorphisme
                        ->latest()
                        ->take(4)
                        ->get();

        // 5. Retourner la vue avec toutes les données
        return view('reader.dashboard', compact(
            'docsLus',
            'favorisCount',
            'projetsCount',
            'recentDocs',
            'favoris'
        ));
    }
}
