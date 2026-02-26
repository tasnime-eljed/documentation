<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

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
        return view('reader.profile', compact('user'));
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
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Gestion de l'upload de l'avatar
        if ($request->hasFile('avatar')) {
            // 1. Supprimer l'ancienne image si elle existe
            if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
                Storage::disk('public')->delete($user->avatar);
            }

            // 2. Stocker la nouvelle image
            $path = $request->file('avatar')->store('avatars', 'public');
            $user->avatar = $path;
        }

        $user->nom = $validated['nom'];
        $user->email = $validated['email'];
        $user->save();

        return back()->with('success', 'Profil mis à jour avec succès.');
    }


    /**
     * Supprimer la photo de profil
     */
    public function deleteAvatar()
    {
        $user = Auth::user();

        if ($user->avatar) {
            // Supprimer le fichier physique
            if (Storage::disk('public')->exists($user->avatar)) {
                Storage::disk('public')->delete($user->avatar);
            }
            // Supprimer la référence en base de données
            $user->avatar = null;
            $user->save();
        }

        return back()->with('success', 'Photo de profil supprimée.');
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
