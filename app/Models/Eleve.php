<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Eleve extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'classe',
        'adresse',
    ];
    //relation avec user
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    public function inscriptions()
    {
        return $this->hasMany(Inscription::class, 'eleve_id', 'id');
    }
    public function classes()
    {
        return $this->belongsToMany(Classe::class, 'classe_eleve', 'eleve_id', 'classe_id');
    }
}
