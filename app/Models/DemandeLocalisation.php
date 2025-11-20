<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DemandeLocalisation extends Model
{
    use HasFactory;

    protected $fillable = [
        'demande_id',
        'departement_id',
        'commune_id',
        'lieux',
        'homme_touche',
        'femme_touche',
    ];

    public function demande()
    {
        return $this->belongsTo(Demande::class);
    }

    public function departement()
    {
        return $this->belongsTo(Departement::class);
    }

    public function commune()
    {
        return $this->belongsTo(Commune::class);
    }
}