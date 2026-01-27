<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
    //Définit explicitement le nom de la table pivot en base de données
    protected $table = 'favorites';

    // Colonnes autorisées pour create / update
    protected $fillable = [
        'user_id',
        'favoritable_id',
        'favoritable_type',
    ];

    // ============================
    // Relations polymorphiques
    // ============================

    /**
     * L'utilisateur qui a ajouté ce favori
     */
    public function user()
    {
        return $this->belongsTo(User::class);
        // belongsTo: relation plusieurs a un
        // un favori appartient a un user
        // un user peut avoir plusieurs favoris
    }

    /**
     * L'objet favori (Project, Category, Documentation)
     */
    public function favoritable()
    {
        return $this->morphTo();
        // morphTo: relation polymorphique inverse

    }

    // ============================
    // Méthodes pratiques
    // ============================

    /**
     * Ajouter un favori
     */
    public static function ajouterAuxFavoris($user_id, Model $objet)
    {
        return self::firstOrCreate([//self: fait référence a la classe courante Favorite
        // firstOrCreate: cherche un enregistrement correspondant aux attributs, sinon le crée
            'user_id' => $user_id,
            'favoritable_id' => $objet->id,
            'favoritable_type' => get_class($objet),
        ]);
    }

    /**
     * Retirer un favori
     */
    public static function retirerFavori($user_id, Model $objet)
    {
        return self::where('user_id', $user_id)
                   ->where('favoritable_id', $objet->id)
                   ->where('favoritable_type', get_class($objet))
                   ->delete();
    }
}
