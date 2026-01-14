<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [
        'nom',
        'projectId',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class, 'projectId');
    }

    public function documentations()
    {
        return $this->hasMany(Documentation::class, 'categoryId');
    }

    public function ajouterDocumentation(array $data)
    {
        $data['categoryId'] = $this->id;
        return Documentation::create($data);
    }

    public function modifierDocumentation($id, array $data)
    {
        $documentation = $this->documentations()->findOrFail($id);
        $documentation->update($data);
        return $documentation;
    }

    public function supprimerDocumentation($id)
    {
        return $this->documentations()->where('id', $id)->delete();
    }
}
