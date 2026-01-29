<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    /**
     * Afficher le formulaire de connexion
     */
    public function showLoginForm()
    {
        // Si l'utilisateur est déjà connecté
        if (Auth::check()) {
            return $this->redirectByRole(Auth::user());
            // Redirige selon le rôle de l'utilisateur
        }

        return view('auth.login');
        //'auth.login' fait référence à la vue située dans resources/views/auth/login.blade.php.
    }

    /**
     * Traitement de la connexion
     */
    public function login(Request $request)
    {
        // Validation des champs
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Tentative de connexion
        if (Auth::attempt($credentials))// Auth::attempt() : tente de connecter l'utilisateur avec les identifiants fournis
        {
            $request->session()->regenerate(); // sécurité session
            // cree un nouveau ID de session pour prévenir les attaques de fixation de session

            return $this->redirectByRole(Auth::user());
        }

        return back()->withErrors([
            'email' => 'Les identifiants ne correspondent pas.',
        ])->onlyInput('email');
    }

    /**
     * Afficher le formulaire d'inscription
     */
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    /**
     * Traitement de l'inscription
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [ //une instance de Validator est créée pour valider les données d'entrée
            'nom' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }

        // Création de l'utilisateur
        $user = User::create([
            'nom' => $request->nom,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'reader', // ⚠️ IMPORTANT : compatible avec User::isReader()
        ]);

        // Connexion automatique après inscription
        Auth::login($user);

        return $this->redirectByRole($user);
    }

    /**
     * Déconnexion
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        // Invalide la session pour des raisons de sécurité
        $request->session()->regenerateToken();
        // Regénère le token CSRF

        return redirect('/');
    }

    /**
     * Redirection selon le rôle
     */
    private function redirectByRole(User $user)
    {
        if ($user->isAdmin()) {
            return redirect()->route('admin.dashboard');
            //admin.dashboard : route vers le tableau de bord admin
        }

        return redirect()->route('reader.dashboard');
        //dashboard : route vers le tableau de bord utilisateur standard
    }

    /**
     * Alias français (optionnel)
     */
    public function seConnecter(Request $request)
    {
        return $this->login($request);
    }

    public function sAuthentifier(Request $request)
    {
        return $this->login($request);
    }
}
