<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SharedLink extends Model
{
    protected $table = 'shared_links';

    protected $fillable = [
        'docId',
        'token',
        'date_creation',
    ];

    protected $casts = [
        'date_creation' => 'datetime',
    ];

    public function documentation()
    {
        return $this->belongsTo(Documentation::class, 'docId');
    }

    public function genererLien()
    {
        return url('/shared/' . $this->token);
    }

    public function verifierLien($token)
    {
        return self::where('token', $token)->exists();
    }
}
