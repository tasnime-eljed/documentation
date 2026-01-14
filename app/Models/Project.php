<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = [
        'nom',
        'description',
        'date_creation',
        'userId',
    ];

    protected $casts = [
        'date_creation' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'userId');
    }

    public function categories()
    {
        return $this->hasMany(Category::class, 'projectId');
    }

    public function ajouterCategorie(array $data)
    {
        $data['projectId'] = $this->id;
        return Category::create($data);
    }

    public function modifierCategorie($id, array $data)
    {
        $category = $this->categories()->findOrFail($id);
        $category->update($data);
        return $category;
    }

    public function supprimerCategorie($id)
    {
        return $this->categories()->where('id', $id)->delete();
    }
}
