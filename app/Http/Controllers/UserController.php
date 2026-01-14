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

    public function profile()
    {
        $user = Auth::user();
        return view('users.profile', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
        ]);

        $user->update($validated);

        return back()->with('success', 'Profil mis à jour avec succès');
    }

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

        $user->update([
            'password' => Hash::make($request->password),
        ]);

        return back()->with('success', 'Mot de passe changé avec succès');
    }

    public function seConnecter(Request $request)
    {
        return app(AuthController::class)->login($request);
    }

    public function lireDocumentation($id)
    {
        return app(DocumentationController::class)->show($id);
    }

    public function ajouterProjet(Request $request)
    {
        return app(ProjectController::class)->store($request);
    }

    public function consulterFavoris()
    {
        return app(FavoriteController::class)->index();
    }
}
