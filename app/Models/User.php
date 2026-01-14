<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'nom',
        'email',
        'role',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function documentations()
    {
        return $this->hasMany(Documentation::class, 'userId');
    }

    public function projects()
    {
        return $this->hasMany(Project::class, 'userId');
    }

    public function favoris()
    {
        return $this->belongsToMany(Documentation::class, 'favoris', 'userId', 'docId');
    }

    public function isAdmin()
    {
        return $this->role === 'admin';
    }
}
