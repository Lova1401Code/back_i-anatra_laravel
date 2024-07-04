<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Badge extends Model
{
    use HasFactory;
    protected $fillable = ['titre', 'eleve_id', 'qr_code', 'description'];

    public function eleve()
    {
        return $this->belongsTo(Eleve::class);
    }
}
