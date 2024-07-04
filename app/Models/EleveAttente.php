<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EleveAttente extends Model
{
    use HasFactory;

    protected $fillable = [
        'matricule',
        'nom',
        'prenom',
        'email',
        'date_naissance',
        'photo_profil',
        'pere_nom',
        'pere_prenom',
        'pere_contact',
        'profession_pere',
        'mere_nom',
        'mere_prenom',
        'mere_contact',
        'profession_mere',
        'tuteur_nom',
        'tuteur_prenom',
        'tuteur_contact',
        'emailParent',
    ];
}
