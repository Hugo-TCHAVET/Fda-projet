<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DemandeCloture extends Model
{
    use HasFactory;

    protected $table = 'demandes_clotures';

    protected $guarded = [];

    protected $casts = [
        'date_transmission' => 'datetime',
        'date_depot_rapport' => 'datetime',
        'date_approbation' => 'datetime',
        'date_archivage' => 'datetime',
        'date_cloture' => 'datetime',
        'archivee' => 'boolean',
        'rapport_depose' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function localisations()
    {
        return $this->hasMany(DemandeLocalisationCloture::class, 'demande_cloture_id');
    }
}
