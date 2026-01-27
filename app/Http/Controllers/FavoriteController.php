<?php

namespace App\Http\Controllers;

use App\Models\Favorite;
use App\Models\Project;
use App\Models\Category;
use App\Models\Documentation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        // Seul un utilisateur connecté peut accéder aux méthodes
    }

    /**
     * Liste des favoris de l'utilisateur
     */
    public function index()
    {
        $user = Auth::user();// Récupère l'utilisateur authentifié

        // Récupère tous les favoris polymorphiques avec leurs relations
        $favoris = $user->favorites()->with('favoritable')->get();

        return view('favoris.index', compact('favoris'));
        // Passe la variable $favoris à la vue
        //'favoris.index' fait référence à la vue située dans resources/views/favoris/index.blade.php.
    }

    /**
     * Ajouter un favori (Project, Category ou Documentation)
     */
    public function ajouterAuxFavoris(Request $request)
    {
        $request->validate([
            'favoritable_id' => 'required|integer',
            'favoritable_type' => 'required|string|in:Project,Category,Documentation',
        ]);

        $classMap = [
            'Project' => Project::class,
            'Category' => Category::class,
            'Documentation' => Documentation::class,
        ];//transforme le type en classe complète reelle

        $objet = $classMap[$request->favoritable_type]::findOrFail($request->favoritable_id);
        // findOrFail : récupère l'objet ou renvoie une erreur 404 s'il n'existe pas.
        Favorite::ajouterAuxFavoris(Auth::id(), $objet);
        //appelle la méthode statique ajouterAuxFavoris du modèle Favorite
        //Auth::id() : récupère l'ID de l'utilisateur authentifié.

        if ($request->expectsJson()) {
            // Vérifie si la requête attend une réponse JSON
            return response()->json([
                // Retourne une réponse JSON indiquant le succès
                'success' => true,
                'message' => 'Ajouté aux favoris',
            ]);
        }

        return back()->with('success', 'Ajouté aux favoris');
        // Redirige l'utilisateur vers la page précédente avec un message de succès
    }

    /**
     * Retirer un favori (Project, Category ou Documentation)
     */
    public function retirerFavori(Request $request)
    {
        $request->validate([
            'favoritable_id' => 'required|integer',
            'favoritable_type' => 'required|string|in:Project,Category,Documentation',
        ]);

        $classMap = [
            'Project' => Project::class,
            'Category' => Category::class,
            'Documentation' => Documentation::class,
        ];

        $objet = $classMap[$request->favoritable_type]::findOrFail($request->favoritable_id);
        // findOrFail : récupère l'objet ou renvoie une erreur 404 s'il n'existe pas.
        Favorite::retirerFavori(Auth::id(), $objet);
        //appelle la méthode statique retirerFavori du modèle Favorite
        //Auth::id() : récupère l'ID de l'utilisateur authentifié.
        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Retiré des favoris',
            ]);
        }

        return back()->with('success', 'Retiré des favoris');
        // Redirige l'utilisateur vers la page précédente avec un message de succès
    }
}
