<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    protected $fillable = [
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function ajouterProjet(array $data)
    {
        return Project::create($data);
    }

    public function modifierProjet($id, array $data)
    {
        $project = Project::findOrFail($id);
        $project->update($data);
        return $project;
    }

    public function supprimerProjet($id)
    {
        return Project::destroy($id);
    }

    public function ajouterCategorie(array $data)
    {
        return Category::create($data);
    }

    public function modifierCategorie($id, array $data)
    {
        $category = Category::findOrFail($id);
        $category->update($data);
        return $category;
    }

    public function supprimerCategorie($id)
    {
        return Category::destroy($id);
    }

    public function ajouterDocumentation(array $data)
    {
        return Documentation::create($data);
    }

    public function modifierDocumentation($id, array $data)
    {
        $documentation = Documentation::findOrFail($id);
        $documentation->update($data);
        return $documentation;
    }

    public function supprimerDocumentation($id)
    {
        return Documentation::destroy($id);
    }

    public function genererLienPartage($docId)
    {
        return SharedLink::create([
            'docId' => $docId,
            'token' => bin2hex(random_bytes(32)),
            'date_creation' => now(),
        ]);
    }
}
