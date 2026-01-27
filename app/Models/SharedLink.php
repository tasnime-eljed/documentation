<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SharedLink extends Model
{
    protected $table = 'shared_links';

    protected $fillable = [
        'documentation_id', // lien lié à une doc spécifique
        'token',
        'created_at',
    ];

    protected $casts = [
        'created_at' => 'datetime',
    ];

    // ============================
    // Relation
    // ============================

    /**
     * Chaque SharedLink appartient à une Documentation
     */
    public function documentation()
    {
        return $this->belongsTo(Documentation::class);
        // belongsTo: relation plusieurs a un
        // un lien partagé appartient a une documentation
        // une documentation peut avoir plusieurs liens partagés
    }

    // ============================
    // Méthodes pratiques
    // ============================

    /**
     * Générer le lien complet pour la doc spécifique
     */
    public function genererLien(): string
    {
        return url('/shared/documentation/' . $this->token);
        // url: génère une URL complète
        // '/shared/documentation/': chemin de base pour les liens partagés
        //ajoute le token unique à l'URL de base
    }

    /**
     * Vérifier si le lien existe
     */
    public static function verifierLien(string $token): bool
    {
        return self::where('token', $token)->exists();
        // self: fait référence a la classe courante SharedLink
        // where: filtre les enregistrements par token
        // exists: vérifie si un enregistrement correspondant existe
    }
}
