<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Matiere extends Model
{
    use HasFactory;
    protected $fillable = [
        'nom',
        'annee_scolaire_id',
        'enseignant_id',
        'semestre_id',
        'coefficient'
    ];
    public function anneeScolaire()
    {
        return $this->belongsTo(AnneeScolaire::class);
    }
    public function enseignant()
    {
        return $this->belongsTo(Enseignant::class);
    }
    public function semestre()
    {
        return $this->belongsTo(Semestre::class);
    }
    public function notes()
    {
        return $this->hasMany(Note::class);
    }
}
