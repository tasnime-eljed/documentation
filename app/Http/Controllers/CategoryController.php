<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Project;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Liste des catégories (admin + reader)
     */
    public function index()
    // Afficher une liste paginée des catégories
    {
        $categories = Category::with('project')->latest()->paginate(15);
        //Category::latest() récupère les catégories triées par date de création décroissante.
        // Retourner la vue avec les catégories paginées
        return view('categories.index', compact('categories'));
        //'categories.index' fait référence à la vue située dans resources/views/categories/index.blade.php.
        // La méthode compact('categories') crée un tableau associatif avec la clé 'categories' et la variable $categories.
    }

    /**
     * Afficher une catégorie avec ses documentations et projet (admin + reader)
     */
    public function show(Category $category)
    //$category : la catégorie à afficher
    //  injectée automatiquement par Laravel via le route model binding.
    {
        $category->load('documentations', 'project');
        //load('documentations', 'project') charge les relations 'documentations' et 'project'
        // pour éviter les requêtes supplémentaires lors de l'accès à ces relations dans la vue.
        return view('categories.show', compact('category'));
        //'categories.show' fait référence à la vue située dans resources/views/categories/show.blade.php.
    }

    /**
     * Formulaire création (ADMIN seulement)
     */

    public function create()
    {
        $this->authorizeAdmin();
        // Vérifie si l'utilisateur est admin
        $projects = Project::all();
        return view('categories.create', compact('projects'));
        //'categories.create' fait référence à la vue située dans resources/views/categories/create.blade.php.
    }

    /**
     * Enregistrer une catégorie (ADMIN seulement)
     */

    public function store(Request $request)
    {
        $this->authorizeAdmin();

        $data = $request->validate([
            'nom' => 'required|string|max:255',
            'project_id' => 'required|exists:projects,id',
        ]);

        Category::create($data);
        // Crée une nouvelle catégorie avec les données validées
        return redirect()->route('admin.categories.index')
        // Redirige vers la liste des catégories
                         ->with('success', 'Catégorie créée avec succès');
    }

    /**
     * Formulaire modification (ADMIN seulement)
     */
    public function edit(Category $category)
    {
        $this->authorizeAdmin();
        $projects = Project::all();
        return view('categories.edit', compact('category','projects'));

    }

    /**
     * Mettre à jour une catégorie (ADMIN seulement)
     */
    public function update(Request $request, Category $category)
    {
        $this->authorizeAdmin();

        $data = $request->validate([
            'nom' => 'required|string|max:255',
            'project_id' => 'required|exists:projects,id',
        ]);

        $category->update($data);

        return redirect()->route('admin.categories.show', $category)
        // Redirige vers la page de la catégorie modifiée
                         ->with('success', 'Catégorie modifiée');
    }

    /**
     * Supprimer une catégorie (ADMIN seulement)
     */
    public function destroy(Category $category)
    {
        $this->authorizeAdmin();

        $category->delete();

        return redirect()->route('admin.categories.index')
                         ->with('success', 'Catégorie supprimée');
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
