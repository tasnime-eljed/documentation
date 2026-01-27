<?php

namespace App\Http\Controllers;

use App\Models\Documentation;
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
    // Récupère les documentations avec leurs relations 'category.project' et 'user'
    //  triées par date de création décroissante
    //  paginées par 12 par page.

        return view('documentations.index', compact('documentations'));
        //'documentations.index' fait référence à la vue située dans resources/views/documentations/index.blade.php.
    }

    /**
     * Afficher une documentation (admin + reader)
     */
    public function show(Documentation $documentation)
    {
        // Charger les relations
        $documentation->load('category.project', 'user', 'sharedLinks');
        // 'category.project', 'user', 'sharedLinks' sont chargés pour éviter les requêtes supplémentaires dans la vue.

        // Incrémenter le nombre de vues
        $documentation->incrementerVues();

        // Vérifier si l'utilisateur a ajouté aux favoris
        $isFavorite = false;
        if (Auth::check()) {
            //  verifier si L'utilisateur est authentifié
            $isFavorite = Auth::user()->favorites()//recupère les favoris de l'utilisateur
                                     ->where('favoritable_id', $documentation->id)
                                     ->where('favoritable_type', Documentation::class)
                                     ->exists();// Vérifie si la documentation est dans les favoris
        }

        return view('documentations.show', compact('documentation', 'isFavorite'));
        //'documentations.show' fait référence à la vue située dans resources/views/documentations/show.blade.php.
        // La variable $isFavorite indique si la documentation est dans les favoris de l'utilisateur.
    }

    /**
     * Formulaire création (ADMIN seulement)
     */
    public function create()
    {
        $this->authorizeAdmin();
        return view('documentations.create');
        //'documentations.create' fait référence à la vue située dans resources/views/documentations/create.blade.php.
    }

    /**
     * Enregistrer une documentation (ADMIN seulement)
     */
    public function store(Request $request)
    {
        $this->authorizeAdmin();

        $data = $request->validate([
            'titre' => 'required|string|max:255',
            'contenu' => 'required|string',
            'category_id' => 'required|exists:categories,id',
        ]);

        $data['user_id'] = auth()->id();
        Documentation::create($data);

        return redirect()->route('documentations.index')
        // Redirige vers la liste des documentations
                         ->with('success', 'Documentation créée avec succès');
    }

    /**
     * Formulaire modification (ADMIN seulement)
     */
    public function edit(Documentation $documentation)
    {
        $this->authorizeAdmin();
        return view('documentations.edit', compact('documentation'));
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

        $documentation->update($data);

        return redirect()->route('documentations.show', $documentation)
                         ->with('success', 'Documentation modifiée');
    }

    /**
     * Supprimer une documentation (ADMIN seulement)
     */
    public function destroy(Documentation $documentation)
    {
        $this->authorizeAdmin();

        $documentation->delete();

        return redirect()->route('documentations.index')
                         ->with('success', 'Documentation supprimée');
    }

    /**
     * Ajouter ou retirer des favoris
     */
    public function toggleFavorite(Documentation $documentation)
    {
        $user = auth()->user();
        $user->favorites()->toggle($documentation);
        //toggle(): ajoute la documentation aux favoris si elle n'y est pas,
        // ou la retire si elle y est déjà.
        return redirect()->back()->with('success', 'Favoris mis à jour');
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
