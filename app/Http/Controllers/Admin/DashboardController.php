<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Project;
use App\Models\Category;
use App\Models\Documentation;

class DashboardController extends Controller
{
    public function __construct()//dans le constructeur pour appliquer le middleware à toutes les méthodes du contrôleur
    {
        // Sécurité propre : auth + admin
        $this->middleware(['auth', 'admin']);
        // middleware:garder l’accès aux utilisateurs authentifiés

    }

    /**
     * Dashboard Admin
     */
    public function index() // Afficher le tableau de bord admin
    {
        // ============================
        // Statistiques globales
        // ============================

        $usersCount = User::count();// Compte tous les utilisateurs
        //$usersCount = User::where('role', 'reader')->count(); // Compte uniquement les lecteurs
        $projectsCount = Project::count();
        $categoriesCount = Category::count();
        $docsCount = Documentation::count();

        // ============================
        // Activités récentes
        // ============================

        $recentActivities = [];

        // Derniers projets
        Project::latest()->take(3)->get()->each(function ($project) use (&$recentActivities) {
            //latest() pour trier par date de création décroissante
            //  take(3) pour limiter à 3 résultats
            //get() pour récupérer les résultats
            //each():executer la fonction de rappel pour chaque projet récupéré
            //$recentActivities est passé par référence (&$recentActivities) pour permettre la modification de tableau à l'intérieur de la fonction de rappel
            $recentActivities[] = [
                'user' => $project->user->nom ?? 'Admin', //si pas d'utilisateur associé, afficher 'Admin'
                'action' => 'a créé le projet',
                'target' => $project->nom,//'target' : nom du projet
                'time' => $project->created_at->diffForHumans(),
                //diffForHumans() : format lisible de la date
                'type' => 'project',
            ];
        });

        // Dernières catégories
        Category::latest()->take(2)->get()->each(function ($category) use (&$recentActivities) {
            $recentActivities[] = [
                'user' => $category->project->user->nom ?? 'Admin',
                'action' => 'a créé la catégorie',
                'target' => $category->nom,
                'time' => $category->created_at->diffForHumans(),
                'type' => 'category',
            ];
        });

        // Dernières documentations
        Documentation::latest()->take(3)->get()->each(function ($doc) use (&$recentActivities) {
            $recentActivities[] = [
                'user' => $doc->user->nom ?? 'Admin',
                'action' => 'a créé la documentation',
                'target' => $doc->titre,
                'time' => $doc->created_at->diffForHumans(),
                'type' => 'documentation',
            ];
        });

        // Nouveaux readers (inscriptions)
        User::where('role', 'reader')->latest()->take(2)->get()->each(function ($user) use (&$recentActivities) {
            $recentActivities[] = [
                'user' => $user->nom,
                'action' => 's’est inscrit',
                'target' => 'Compte lecteur',
                'time' => $user->created_at->diffForHumans(),
                'type' => 'user',
            ];
        });

        // Limiter à 8 activités
        $recentActivities = array_slice($recentActivities, 0, 8);//array_slice() : extraire une portion de tableau
        if (empty($recentActivities)) {
        // Si aucune activité, afficher message par défaut
            $recentActivities[] = [
                'user' => 'Système',
                'action' => 'Aucune activité',
                'target' => '',
                'time' => '—',
                'type' => 'system',
            ];
        }

        return view('admin.dashboard', compact(
            // compact():les variables à passer à la vue
            'usersCount',
            'projectsCount',
            'categoriesCount',
            'docsCount',
            'recentActivities'
        ));
    }
}
