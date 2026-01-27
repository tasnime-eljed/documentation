<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Documentation;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        // Toutes les méthodes nécessitent un utilisateur connecté
    }

    /**
     * Afficher le profil de l'utilisateur
     */
    public function profile()
    {
        $user = Auth::user();// Récupère l'utilisateur authentifié
        return view('users.profile', compact('user'));//envoie $user à la vue
        //'users.profile' fait référence à la vue située dans resources/views/users/profile.blade.php.
    }

    /**
     * Mettre à jour le profil de l'utilisateur
     */
    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id, //sauf pour l’utilisateur actuel
        ]);

        $user->update($validated);

        return back()->with('success', 'Profil mis à jour avec succès');
    }

    /**
     * Changer le mot de passe
     */
    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            // Vérifie si le mot de passe actuel est correct avec celui en base
            return back()->withErrors(['current_password' => 'Mot de passe actuel incorrect']);
        }

        $user->update([
            'password' => Hash::make($request->password),
            // Hash::make() : hache le nouveau mot de passe avant de le stocker
        ]);

        return back()->with('success', 'Mot de passe changé avec succès');
    }

    /**
     * Ajouter un projet (ADMIN uniquement)
     */
    public function ajouterProjet(Request $request)
    {
        $user = Auth::user();// Récupère l'utilisateur authentifié
        if (!$user->canCrudProject()) {
            abort(403); // Interdit si pas admin
        }

        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $validated['user_id'] = $user->id;
        // Associe le projet à l'utilisateur actuel
        Project::create($validated);

        return redirect()->route('projects.index')
        // Redirige vers la liste des projets
                         ->with('success', 'Projet créé avec succès');
    }

    /**
     * Lire une documentation (reader + admin)
     */
    public function lireDocumentation($id)
    {
        $user = Auth::user();

        $documentation = Documentation::with(['category.project', 'user'])// Eager loading des relations
                                      ->findOrFail($id);// Récupère la documentation ou renvoie 404

        if (!$user->canRead()) {
            abort(403); // Interdit si role ne peut pas lire
        }

        $documentation->incrementerVues();

        return view('documentations.show', compact('documentation'));
        // 'documentations.show' fait référence à la vue située dans resources/views/documentations/show.blade.php.
    }

    /**
     * Consulter les favoris de l'utilisateur
     */
    public function consulterFavoris()
    {
        $user = Auth::user();
        $favoris = $user->favorites()->with('favoritable')->get();
        // Récupère tous les favoris polymorphiques avec leurs relations

        return view('favoris.index', compact('favoris'));
        //'favoris.index' fait référence à la vue située dans resources/views/favoris/index.blade.php.
    }
}
