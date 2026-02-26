<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class ForgotPasswordController extends Controller
{
    /**
     * Affiche le formulaire de demande de lien (Étape 1)
     */
    public function showLinkRequestForm()
    {
        return view('auth.forgot-password');
    }

    /**
     * Envoie le lien de réinitialisation par email (Étape 2)
     */
    public function sendResetLinkEmail(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        // Envoie le lien
        $status = Password::sendResetLink($request->only('email'));
        // Password::sendResetLink: envoie un email avec le lien de réinitialisation

        if ($status === Password::RESET_LINK_SENT) {// Si le lien a été envoyé avec succès
            return back()->with('status', __($status));// Retourne à la page précédente avec un message de succès
        }//

        throw ValidationException::withMessages([// Si l'envoi a échoué, lance une exception de validation
            'email' => [__($status)],
        ]);
    }

    /**
     * Affiche le formulaire de nouveau mot de passe (Étape 3)
     */
    public function showResetForm(Request $request, $token = null)
    {
        return view('auth.reset-password')->with(
            ['token' => $token, 'email' => $request->email]
        );
    }

    /**
     * Réinitialise le mot de passe (Étape 4)
     */
    public function reset(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => \Illuminate\Support\Facades\Hash::make($password)
                ])->setRememberToken(Str::random(60));

                $user->save();

                // Connecter l'utilisateur automatiquement après le reset
                // event(new PasswordReset($user)); // Optionnel
            }
        );

        if ($status === Password::PASSWORD_RESET) {
            return redirect()->route('login')->with('success', 'Votre mot de passe a été réinitialisé ! Connectez-vous.');
        }

        throw ValidationException::withMessages([
            'email' => [__($status)],
        ]);
    }
}
