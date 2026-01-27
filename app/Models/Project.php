<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = [
        'nom',
        'description',
        'date_creation',
        'user_id',
    ];

    protected $casts = [
        'date_creation' => 'datetime',
    ];

    // ============================
    // Relations
    // ============================

    public function user()
    {
        return $this->belongsTo(User::class);
        // belongsTo: relation plusieurs a un
        // un projet appartient a un user
        //un user peut avoir plusieurs projets
    }

    public function categories()
    {
        return $this->hasMany(Category::class);
        // hasMany: relation un a plusieurs
        // un projet peut avoir plusieurs categories
        // une categorie appartient a un projet
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
