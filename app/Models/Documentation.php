<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Documentation extends Model
{
    protected $table = 'documentations';
    // Par défaut, Laravel aurait utilisé documentations automatiquement
    //  spécifie le nom de la table

    protected $fillable = [
        'titre',
        'contenu',
        'temps_lecture',
        'vues',
        'category_id',
        'user_id',
    ];

    protected $casts = [
        'vues' => 'integer', // caster vues en entier
        'temps_lecture' => 'integer', // caster temps_lecture en entier
    ];

    // ============================
    // Relations
    // ============================

    public function category()
    {
        return $this->belongsTo(Category::class);
        // belongsTo: relation plusieurs a un
        // une documentation appartient a une categorie
        // une categorie peut avoir plusieurs documentations
    }

    public function user()
    {
        return $this->belongsTo(User::class);
        // belongsTo: relation plusieurs a un
        // une documentation appartient a un user
        // un user peut creer plusieurs documentations
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

    public function sharedLinks()
    {
        return $this->hasMany(SharedLink::class);
        // hasMany: relation un a plusieurs
        // une documentation peut avoir plusieurs liens partagés
        // un lien partagé appartient a une documentation
    }

    // ============================
    // Méthodes métier
    // ============================

    public function incrementerVues()
        {
        $this->increment('vues');
        // increment: incremente la colonne vues de 1
    }

    public function calculerTempsLecture()
    {
        $words = str_word_count(strip_tags($this->contenu));
        // str_word_count: compte le nombre de mots
        // strip_tags: supprime les balises HTML
        $minutes = ceil($words / 200); // 200 mots par minute
        // ceil: arrondit a l'entier superieur
        $this->update(['temps_lecture' => $minutes]);
        // update: met a jour la colonne temps_lecture en bdd
        return $minutes;
    }
}
