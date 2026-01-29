<?php

namespace App\Http\Controllers;

use App\Models\Documentation;
use App\Models\Category; // Indispensable pour le menu déroulant
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DocumentationController extends Controller
{
    /**
     * Liste des documentations (admin + reader)
     */
    public function index()
    {
        $documentations = Documentation::with(['category.project', 'user'])
                                       ->latest()
                                       ->paginate(12);

        return view('documentations.index', compact('documentations'));
    }

    /**
     * Afficher une documentation (admin + reader)
     */
    public function show(Documentation $documentation)
    {
        // Charger les relations
        $documentation->load('category.project', 'user', 'sharedLinks');

        // Incrémenter le nombre de vues
        $documentation->incrementerVues();

        // Vérifier si l'utilisateur a ajouté aux favoris
        $isFavorite = false;
        if (Auth::check()) {
            $isFavorite = Auth::user()->favorites()
                                     ->where('favoritable_id', $documentation->id)
                                     ->where('favoritable_type', Documentation::class)
                                     ->exists();
        }

        return view('documentations.show', compact('documentation', 'isFavorite'));
    }

    /**
     * Formulaire création (ADMIN seulement)
     */
    public function create()
    {
        $this->authorizeAdmin();

        // CORRECTION : On récupère les catégories pour le menu déroulant
        $categories = Category::with('project')->get();

        return view('documentations.create', compact('categories'));
    }

    /**
     * Enregistrer une documentation (ADMIN seulement)
     */
    public function store(Request $request)
    {
        $this->authorizeAdmin();

        $data = $request->validate([
            'titre' => 'required|string|max:255', // 'titre' et pas 'title'
            'contenu' => 'required|string',       // 'contenu' et pas 'content'
            'category_id' => 'required|exists:categories,id',
        ]);

        $data['user_id'] = auth()->id();

        // Calcul automatique du temps de lecture (optionnel mais sympa)
        $words = str_word_count(strip_tags($data['contenu']));
        $minutes = ceil($words / 200);
        $data['temps_lecture'] = $minutes > 0 ? $minutes : 1;

        Documentation::create($data);

        // CORRECTION ROUTE : admin.documentations.index
        return redirect()->route('admin.documentations.index')
                         ->with('success', 'Documentation créée avec succès');
    }

    /**
     * Formulaire modification (ADMIN seulement)
     */
    public function edit(Documentation $documentation)
    {
        $this->authorizeAdmin();

        // CORRECTION : On récupère les catégories pour le menu déroulant
        $categories = Category::with('project')->get();

        return view('documentations.edit', compact('documentation', 'categories'));
    }

    /**
     * Mettre à jour une documentation (ADMIN seulement)
     */
    public function update(Request $request, Documentation $documentation)
    {
        $this->authorizeAdmin();

        $data = $request->validate([
            'titre' => 'required|string|max:255',
            'contenu' => 'required|string',
            'category_id' => 'required|exists:categories,id',
        ]);

        // Recalcul du temps de lecture en cas de modification
        $words = str_word_count(strip_tags($data['contenu']));
        $minutes = ceil($words / 200);
        $data['temps_lecture'] = $minutes > 0 ? $minutes : 1;

        $documentation->update($data);

        // CORRECTION ROUTE : admin.documentations.show
        return redirect()->route('admin.documentations.show', $documentation)
                         ->with('success', 'Documentation modifiée');
    }

    /**
     * Supprimer une documentation (ADMIN seulement)
     */
    public function destroy(Documentation $documentation)
    {
        $this->authorizeAdmin();

        $documentation->delete();

        // CORRECTION ROUTE : admin.documentations.index
        return redirect()->route('admin.documentations.index')
                         ->with('success', 'Documentation supprimée');
    }

    /**
     * Ajouter ou retirer des favoris (Méthode Toggle)
     * Note: Dans notre système final, on utilise souvent FavoriteController,
     * mais on peut garder ça si tu as des routes spécifiques.
     */
    public function toggleFavorite(Documentation $documentation)
    {
        $user = auth()->user();
        // Attention : ta relation dans User est un hasMany vers Favorite, pas un morphToMany direct.
        // Cette méthode toggle() native de Laravel ne marchera pas directement sur hasMany.
        // Il vaut mieux utiliser les routes favoris.ajouter / favoris.retirer du FavoriteController.

        return redirect()->back()->with('error', 'Utilisez les boutons favoris dédiés.');
    }

    /**
     * Vérification admin
     */
    private function authorizeAdmin()
    {
        if (!auth()->user() || !auth()->user()->isAdmin()) {
            abort(403);
        }
    }
}
