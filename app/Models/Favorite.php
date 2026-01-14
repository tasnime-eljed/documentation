<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
    protected $table = 'favoris';

    protected $fillable = [
        'userId',
        'docId',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'userId');
    }

    public function documentation()
    {
        return $this->belongsTo(Documentation::class, 'docId');
    }

    public static function ajouterAuxFavoris($userId, $docId)
    {
        return self::firstOrCreate([
            'userId' => $userId,
            'docId' => $docId,
        ]);
    }

    public static function retirerFavori($userId, $docId)
    {
        return self::where('userId', $userId)
                   ->where('docId', $docId)
                   ->delete();
    }
}
