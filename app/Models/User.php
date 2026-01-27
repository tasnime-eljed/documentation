<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;//permet de generer des factories(tests,seeders) )
use Illuminate\Foundation\Auth\User as Authenticatable;//permet d'utiliser les fonctionnalitées d'authentification
use Illuminate\Notifications\Notifiable;//permet d'envoyer des notifications
use Laravel\Sanctum\HasApiTokens;//permet de gerer les tokens d'API

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    //hasFactory: pour les factories
    //  Notifiable: pour les notifications hasApiTokens: pour les tokens d'API

    protected $fillable = [
        //fillable: autoriser les champs
        //  liste des colonnes qu’on peut remplir via User::create()
        'nom',
        'email',
        'password',
        'role',
    ];

    protected $hidden = [
        //hidden: cacher les champs
        // ces colonnes ne seront jamais renvoyées si tu fais User::all()
        'password',
        'remember_token',
    ];

    protected $casts = [//casts: convertir les champs
        'email_verified_at' => 'datetime',
         //casts: convertir les champs
         //  convertir email_verified_at en instance de Carbon (date/heure)
    ];

    // ============================
    // Méthodes de rôle
    // ============================

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isReader(): bool
    {
        return $this->role === 'reader';
    }

    // ============================
    // Méthodes de permissions
    // ============================

    public function canRead(): bool
    {
        return in_array($this->role, ['admin', 'reader']);
        // in_array :verifie si le role est dans le tableau
    }

    public function canCrudProject(): bool
    {
        return $this->role === 'admin';
    }

    public function canCrudCategory(): bool
    {
        return $this->role === 'admin';
    }

    public function canCrudDocumentation(): bool
    {
        return $this->role === 'admin';
    }

    public function canCrudSharedLink(): bool
    {
        return $this->role === 'admin';
    }

    public function canAddFavorite(): bool
    {
        return in_array($this->role, ['admin', 'reader']);
    }

    // ============================
    // Relations
    // ============================

    // Favorites polymorphique (Projects, Categories, Documentations)
   public function favorites()
{
    return $this->morphToMany(
        'App\Models\Favoritable', // polymorphique, juste pour type hint
        'favoritable',// nom de la relation polymorphique
        'favorites',// nom de la table pivot
        'user_id',// clé étrangère de User dans la table pivot
        'favoritable_id'// clé étrangère de l'entité favoritable dans la table pivot

    );
}

    // Example relations si tu veux
    public function projects()
    {
        return $this->hasMany(Project::class);
        // hasMany: relation un a plusieurs
        // un user peut creer plusieurs projets
    }

    public function categories()
    {
        return $this->hasMany(Category::class);
        //un user peut creer plusieurs categories
    }

    public function documentations()
    {
        return $this->hasMany(Documentation::class);
        //un user peut creer plusieurs documentations
    }
}
