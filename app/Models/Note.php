<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    use HasFactory;
    protected $fillable = ['note_interro1', 'note_interro2', 'note_examen', 'eleve_id','annee_scolaire_id', 'enseignant_id', 'matiere_id', 'semestre_id', 'note', 'commentaire', 'date'];

    public function eleve()
    {
        return $this->belongsTo(Eleve::class, 'eleve_id', 'id');
    }

    public function matiere()
    {
        return $this->belongsTo(Matiere::class, 'matiere_id', 'id');
    }

    public function semestre()
    {
        return $this->belongsTo(Semestre::class, 'semestre_id', 'id');
    }
    public function anneeScolaire()
    {
        return $this->belongsTo(AnneeScolaire::class, 'semestre_id', 'id');
    }
}
