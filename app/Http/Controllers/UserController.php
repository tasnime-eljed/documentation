<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // =========================================================================
    // SECTION ADMIN (Gestion des utilisateurs)
    // =========================================================================

    /**
     * Liste de tous les utilisateurs (Pour l'Admin)
     * Route: admin.users.index
     */
    public function index()
    {
        $this->authorizeAdmin(); // Sécurité

        $users = User::latest()->paginate(10);

        // Retourne la vue que je t'ai donnée : resources/views/admin/users/index.blade.php
        return view('admin.users.index', compact('users'));
    }

    /**
     * Voir le profil détaillé d'un utilisateur (Pour l'Admin)
     * Route: admin.users.show
     */
    public function show($id)
    {
        $this->authorizeAdmin(); // Sécurité

        // On récupère l'user avec ses projets et ses favoris pour le rapport complet
        $user = User::with(['projects', 'favorites.favoritable'])->findOrFail($id);

        // Retourne la vue : resources/views/admin/users/show.blade.php
        return view('admin.users.show', compact('user'));
    }

    /**
     * Supprimer un utilisateur (Pour l'Admin)
     */
    public function destroy($id)
    {
        $this->authorizeAdmin();

        $user = User::findOrFail($id);

        // Empêcher l'admin de se supprimer lui-même
        if ($user->id === Auth::id()) {
            return back()->with('error', 'Vous ne pouvez pas supprimer votre propre compte.');
        }

        $user->delete();

        return redirect()->route('admin.users.index')
                         ->with('success', 'Utilisateur supprimé avec succès.');
    }

    // =========================================================================
    // SECTION PROFIL (Pour l'utilisateur connecté)
    // =========================================================================

    /**
     * Afficher mon propre profil
     */
    public function profile()
    {
        $user = Auth::user();
        // Assure-toi d'avoir créé le fichier resources/views/users/profile.blade.php
        // Sinon, tu peux rediriger vers le dashboard ou créer cette vue.
        return view('users.profile', compact('user'));
    }

    /**
     * Mettre à jour mes informations
     */
    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
        ]);

        /** @var \App\Models\User $user */
        $user->update($validated);

        return back()->with('success', 'Profil mis à jour avec succès');
    }

    /**
     * Changer mon mot de passe
     */
    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Mot de passe actuel incorrect']);
        }

        /** @var \App\Models\User $user */
        $user->update([
            'password' => Hash::make($request->password),
        ]);

        return back()->with('success', 'Mot de passe changé avec succès');
    }

    // =========================================================================
    // HELPERS
    // =========================================================================

    private function authorizeAdmin()
    {
        if (!Auth::user()->isAdmin()) {
            abort(403, 'Accès réservé aux administrateurs.');
        }
    }
}
