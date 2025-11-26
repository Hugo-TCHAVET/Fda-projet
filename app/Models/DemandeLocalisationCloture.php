<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Departement;
use App\Models\Commune;

class DemandeLocalisationCloture extends Model
{
    use HasFactory;

    protected $table = 'demande_localisations_clotures';

    protected $guarded = [];

    public function demandeCloture()
    {
        return $this->belongsTo(DemandeCloture::class, 'demande_cloture_id');
    }

    public function departement()
    {
        return $this->belongsTo(Departement::class, 'departement_id');
    }

    public function commune()
    {
        return $this->belongsTo(Commune::class, 'commune_id');
    }
}
