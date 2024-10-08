<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Enseignant extends Model
{
    use HasFactory, Notifiable;
    protected $fillable = [
        'user_id', 'specialite', 'telephone', 'adresse'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    public function classes()
    {
        return $this->hasMany(Classe::class, 'enseignant_id', 'id');
    }

}
