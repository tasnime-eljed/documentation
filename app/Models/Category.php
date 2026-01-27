<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [
        'nom',
        'project_id',
    ];

    // ============================
    // Relations
    // ============================

    public function project()
    {
        return $this->belongsTo(Project::class);
        // belongsTo: relation plusieurs a un
        // une categorie appartient a un projet
        // un projet peut avoir plusieurs categories
    }

    public function documentations()
    {
        return $this->hasMany(Documentation::class);
        // hasMany: relation un a plusieurs
        // une categorie peut avoir plusieurs documentations
        // une documentation appartient a une categorie
    }
      public function favoritedBy()
{
    return $this->morphToMany(User::class, 'favoritable', 'favorites', 'favoritable_id', 'user_id');
}
    // favoritedBy: users qui ont mis ce projet en favori
    // morphToMany: relation polymorphique plusieurs a plusieurs
    // User::class: le modèle lié
    // 'favoritable': nom de la relation polymorphique
    // 'favorites': nom de la table pivot
    // 'favoritable_id': clé étrangère de l'entité favoritable dans la table pivot
    // 'user_id': clé étrangère de User dans la table pivot
}
