<?php

namespace App\Http\Controllers;

use App\Models\SharedLink;
use Illuminate\Http\Request;

class SharedLinkController extends Controller
{
    /**
     * Accéder à une documentation via un lien partagé
     * @param string $token Token unique du lien
     */
    public function accederViaLienPartage(string $token)
    {
        // Récupère le lien partagé correspondant au token ou renvoie 404
        $sharedLink = SharedLink::where('token', $token)->firstOrFail();
        //SharedLink::where('token', $token): filtre la table des liens partagés pour trouver celui avec le token donné.
        // 'firstOrFail()' : renvoie le premier résultat ou une erreur 404 si aucun n'est trouvé.
        // Récupère la documentation associée
        $documentation = $sharedLink->documentation;

        // Incrémente le nombre de vues de la documentation
        $documentation->incrementerVues();

        // Charge les relations nécessaires pour la vue
        $documentation->load('category.project', 'user');

        // Retourne la vue dédiée aux liens partagés
        return view('documentations.shared', compact('documentation', 'sharedLink'));
        // 'documentations.shared' → resources/views/documentations/shared.blade.php
        // La méthode compact('documentation', 'sharedLink'): envoie ces deux variables à la vue.
    }

    /**
     * Alias pour show (compatibilité avec les routes RESTful)
     */
    public function show(string $token)
    {
        return $this->accederViaLienPartage($token);
    }

    /**
     * Générer un nouveau lien partagé pour une documentation (ADMIN seulement)
     */
    public function genererLienPartage($documentationId)
    {
        $this->authorizeAdmin();

        // Génère un token unique
        $token = bin2hex(random_bytes(16));
        //random_bytes(16):16 octets aléatoires
        //bin2hex(): convertit ces octets en une chaîne hexadécimale.

        $sharedLink = SharedLink::create([
            'documentation_id' => $documentationId,
            'token' => $token,
        ]);// Crée un nouveau lien partagé dans la base de données

        return redirect()->back()
                         ->with('success', 'Lien partagé généré avec succès : ' . $sharedLink->genererLien());
                         // Redirige l'utilisateur vers la page précédente avec un message de succès
                         // 'genererLien()' : méthode du modèle SharedLink qui génère l'URL complète du lien partagé.
    }

    /**
     * Supprimer un lien partagé (ADMIN seulement)
     */
    public function supprimerLienPartage(SharedLink $sharedLink)
    {
        $this->authorizeAdmin();

        $sharedLink->delete();

        return redirect()->back()
                         ->with('success', 'Lien partagé supprimé');
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
