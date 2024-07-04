<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Presence extends Model
{
    use HasFactory;
    protected $fillable = ['enseignant_id','eleve_id', 'date', 'present'];

    public function eleve()
    {
        return $this->belongsTo(Eleve::class);
    }
    public function enseignant()
    {
        return $this->belongsTo(Enseignant::class);
    }
}
