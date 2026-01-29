<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
//permet de recupérer les données envoyées par les formulaires HTTP

class ProjectController extends Controller
{


    /**
     * Liste des projets (admin + reader)
     */


    public function index()//méthode pour afficher la liste des projets
    {
        $projects = Project::latest()->paginate(10);
        // Project::latest(): récupère les projets triés par date de création décroissante
        // paginate(10): pagine les résultats, 10 par page
        return view('projects.index', compact('projects'));
        //'projects.index': nom de la vue à afficher resources/views/projects/index.blade.php
        // retourne la vue 'projects.index' avec les projets paginés
        // compact('projects'): crée un tableau associatif avec la variable 'projects' pour la vue
    }



    /**
     * Afficher un projet avec ses catégories et docs (admin + reader)
     */

    public function show(Project $project)
    //méthode pour afficher un projet spécifique
    {
        $project->load('categories.documentations');
        // load: charge les relations spécifiées
        // 'categories.documentations': charge les catégories du projet et leurs documentations associées
        return view('projects.show', compact('project'));
        //'projects.show': nom de la vue à afficher resources/views/projects/show.blade.php
        // retourne la vue 'projects.show' avec le projet chargé
        // compact('project'): crée un tableau associatif avec la variable 'project' pour la vue
    }


    /**
     * Formulaire de création (ADMIN seulement)
     */


    public function create()
    //méthode pour afficher le formulaire de création de projet
    {
        $this->authorizeAdmin();
        // vérifie si l'utilisateur est admin
        return view('projects.create');
        //'projects.create': nom de la vue à afficher resources/views/projects/create.blade.php
    }

    /**
     * Enregistrer un projet (ADMIN seulement)
     */



    public function store(Request $request)
    //méthode pour enregistrer un nouveau projet
    // reçoit les données du formulaire via l'objet Request
    {
        $this->authorizeAdmin();
        // vérifie si l'utilisateur est admin

        $data = $request->validate([
            'nom' => 'required|string|max:255',
            'description' => 'nullable|string',//NULLABLE: champ optionnel
        ]);

        $data['user_id'] = auth()->id();
        // assigne l'ID de l'utilisateur connecté au projet
        Project::create($data);
        // crée un nouveau projet avec les données validées
        return redirect()->route('admin.projects.index')
        // redirige vers la liste des projets
                         ->with('success', 'Projet créé avec succès');
                         // ajoute un message de succès à la session
    }



    /**
     * Formulaire modification (ADMIN seulement)
     */

    public function edit(Project $project)
    {
        $this->authorizeAdmin();
        return view('projects.edit', compact('project'));
        //'projects.edit': nom de la vue à afficher resources/views/projects/edit.blade.php
        //affiche le formulaire avec les données du projet à modifier
    }

    /**
     * Mettre à jour un projet (ADMIN seulement)
     */


    public function update(Request $request, Project $project)
    {
        $this->authorizeAdmin();

        $data = $request->validate([
            'nom' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $project->update($data);

        return redirect()->route('admin.projects.show', $project)
        // redirige vers la page du projet modifié
                         ->with('success', 'Projet modifié');
    }


    /**
     * Supprimer un projet (ADMIN seulement)
     */


    public function destroy(Project $project)
    {
        $this->authorizeAdmin();

        $project->delete();

        return redirect()->route('admin.projects.index')
        // redirige vers la liste des projets
                         ->with('success', 'Projet supprimé');
    }

    /**
     * Vérification admin
     */

    private function authorizeAdmin()
    {
        if (!auth()->user() || !auth()->user()->isAdmin()) {
            // !auth()->user(): vérifie si l'utilisateur est connecté
            // !auth()->user()->isAdmin(): vérifie si l'utilisateur n'est pas admin
            abort(403);
            // abort(403): arrête l'exécution et renvoie une erreur 403 (interdit)
        }
    }
}
