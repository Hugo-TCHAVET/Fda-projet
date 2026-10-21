<?php

namespace App\Models;

use App\Models\Brache;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Demande extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'date_transmission' => 'datetime',
        'date_depot_rapport' => 'datetime',
        'date_approbation' => 'datetime',
        'date_archivage' => 'datetime',
        'archivee' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    private const LIBELLES_SERVICE = [
        'Assistance' => 'Activités de Promotion',
        'Formation' => 'Formation / Renforcement de capacités',
        'Financier' => 'Appui Financier',
    ];

    public static function libelleService(?string $service): string
    {
        return self::LIBELLES_SERVICE[$service] ?? ($service ?: 'Non renseigné');
    }

    // rapport_fichier can be overwritten through other forms: only trust paths inside rapports/.
    public function cheminRapportSur(): ?string
    {
        $chemin = $this->rapport_fichier;

        return $chemin && str_starts_with($chemin, 'rapports/') && !str_contains($chemin, '..') ? $chemin : null;
    }

    public function branche()
    {
        return $this->belongsTo(Brache::class);
    }

    public function localisations()
    {
        return $this->hasMany(DemandeLocalisation::class);
    }
}
