<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Project;
use App\Models\Category;
use App\Models\Documentation;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (!Auth::user() || !Auth::user()->isAdmin()) {
                abort(403, 'Accès non autorisé');
            }
            return $next($request);
        });
    }

    public function dashboard()
    {
        $stats = [
            'projects' => Project::count(),
            'categories' => Category::count(),
            'documentations' => Documentation::count(),
            'users' => User::count(),
        ];

        return view('admin.dashboard', compact('stats'));
    }

    // Gestion des projets
    public function ajouterProjet(Request $request)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $validated['userId'] = Auth::id();
        $validated['date_creation'] = now();

        $project = Project::create($validated);

        return redirect()->route('admin.projects.index')
                         ->with('success', 'Projet créé avec succès');
    }

    public function modifierProjet(Request $request, $id)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $project = Project::findOrFail($id);
        $project->update($validated);

        return redirect()->route('admin.projects.show', $id)
                         ->with('success', 'Projet modifié avec succès');
    }

    public function supprimerProjet($id)
    {
        $project = Project::findOrFail($id);
        $project->delete();

        return redirect()->route('admin.projects.index')
                         ->with('success', 'Projet supprimé avec succès');
    }

    // Gestion des catégories
    public function ajouterCategorie(Request $request)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'projectId' => 'required|exists:projects,id',
        ]);

        $category = Category::create($validated);

        return redirect()->route('admin.categories.index')
                         ->with('success', 'Catégorie créée avec succès');
    }

    public function modifierCategorie(Request $request, $id)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'projectId' => 'required|exists:projects,id',
        ]);

        $category = Category::findOrFail($id);
        $category->update($validated);

        return redirect()->route('admin.categories.show', $id)
                         ->with('success', 'Catégorie modifiée avec succès');
    }

    public function supprimerCategorie($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();

        return redirect()->route('admin.categories.index')
                         ->with('success', 'Catégorie supprimée avec succès');
    }

    // Gestion des documentations
    public function ajouterDocumentation(Request $request)
    {
        $validated = $request->validate([
            'titre' => 'required|string|max:255',
            'contenu' => 'required|string',
            'categoryId' => 'required|exists:categories,id',
        ]);

        $validated['userId'] = Auth::id();
        $validated['vues'] = 0;

        $documentation = Documentation::create($validated);
        $documentation->calculerTempsLecture();

        return redirect()->route('admin.documentations.index')
                         ->with('success', 'Documentation créée avec succès');
    }

    public function modifierDocumentation(Request $request, $id)
    {
        $validated = $request->validate([
            'titre' => 'required|string|max:255',
            'contenu' => 'required|string',
            'categoryId' => 'required|exists:categories,id',
        ]);

        $documentation = Documentation::findOrFail($id);
        $documentation->update($validated);
        $documentation->calculerTempsLecture();

        return redirect()->route('admin.documentations.show', $id)
                         ->with('success', 'Documentation modifiée avec succès');
    }

    public function supprimerDocumentation($id)
    {
        $documentation = Documentation::findOrFail($id);
        $documentation->delete();

        return redirect()->route('admin.documentations.index')
                         ->with('success', 'Documentation supprimée avec succès');
    }

    public function genererLienPartage($docId)
    {
        $documentation = Documentation::findOrFail($docId);
        $sharedLink = $documentation->sharedLinks()->create([
            'token' => bin2hex(random_bytes(32)),
            'date_creation' => now(),
        ]);

        return response()->json([
            'success' => true,
            'link' => $sharedLink->genererLien(),
        ]);
    }
}
