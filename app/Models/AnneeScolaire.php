<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AnneeScolaire extends Model
{
    use HasFactory;
    protected $table = 'annees_scolaires';
    protected $fillable = [
        'annee',
        'debut',
        'fin',
        'statut',
    ];

    public static function current()
    {
        return self::where('statut', 'active')->first();
    }
    public function classes()
    {
        return $this->hasMany(Classe::class, 'annee_scolaire_id', 'id');
    }
}
