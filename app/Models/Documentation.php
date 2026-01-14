<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Documentation extends Model
{
    protected $table = 'documentations';

    protected $fillable = [
        'titre',
        'contenu',
        'temps_lecture',
        'vues',
        'categoryId',
        'userId',
    ];

    protected $casts = [
        'vues' => 'integer',
        'temps_lecture' => 'integer',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'categoryId');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'userId');
    }

    public function favoris()
    {
        return $this->belongsToMany(User::class, 'favoris', 'docId', 'userId');
    }

    public function sharedLinks()
    {
        return $this->hasMany(SharedLink::class, 'docId');
    }

    public function incrementerVues()
    {
        $this->increment('vues');
    }

    public function calculerTempsLecture()
    {
        $words = str_word_count(strip_tags($this->contenu));
        $minutes = ceil($words / 200); // 200 mots par minute en moyenne
        $this->update(['temps_lecture' => $minutes]);
        return $minutes;
    }

    public function mettreAJourNombreVues()
    {
        $this->incrementerVues();
    }
}
