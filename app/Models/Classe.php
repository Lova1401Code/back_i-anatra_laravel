<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Classe extends Model
{
    use HasFactory;
    protected $fillable = [
        'nom',
        'annee_scolaire_id',
        'enseignant_id',
    ];
    public function eleves()
    {
        return $this->belongsToMany(Eleve::class, 'classe_eleve', 'classe_id', 'eleve_id');
    }
    public function anneeScolaire()
    {
        return $this->belongsTo(AnneeScolaire::class, 'annee_scolaire_id', 'id');
    }

    public function enseignant()
    {
        return $this->belongsTo(Enseignant::class, 'enseignant_id', 'id');
    }
}
