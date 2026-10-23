<?php

namespace App\Models;

use App\Enums\EtatDemande;
use App\Exceptions\TransitionInterdite;
use App\Models\Branche;
use App\Models\Corp;
use App\Models\Metier;
use Illuminate\Database\Eloquent\Builder;
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
        'budget' => 'integer',
        'budget_accorde' => 'integer',
        'homme_touche' => 'integer',
        'duree_activite' => 'integer',
        'etat' => EtatDemande::class,
        'exercice' => 'integer',
        'cloturee_le' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    protected static function booted()
    {
        // The exercice is the year the demande was created; the closing may carry it over later.
        static::creating(function (Demande $demande) {
            $demande->etat ??= EtatDemande::EnAttente;
            $demande->exercice ??= ($demande->created_at ?? now())->year;
        });
    }

    public function scopeEnCours(Builder $query): void
    {
        $query->whereNull($this->qualifyColumn('cloturee_le'));
    }

    public function scopeCloturees(Builder $query): void
    {
        $query->whereNotNull($this->qualifyColumn('cloturee_le'));
    }

    public function scopeEtat(Builder $query, EtatDemande ...$etats): void
    {
        $query->whereIn($this->qualifyColumn('etat'), array_map(fn (EtatDemande $etat) => $etat->value, $etats));
    }

    public function scopeAllocations(Builder $query): void
    {
        $query->etat(EtatDemande::Approuvee);
    }

    // Demandes handed over to the verification team (transmitted, suspended or approved).
    public function scopeRecues(Builder $query): void
    {
        $query->etat(EtatDemande::Transmise, EtatDemande::Suspendue, EtatDemande::Approuvee);
    }

    private const ETATS_DE_DEPART = [
        'transmettre' => [EtatDemande::EnAttente, EtatDemande::Suspendue],
        'suspendre' => [EtatDemande::Transmise],
        'approuver' => [EtatDemande::Transmise],
    ];

    public function peut(string $transition): bool
    {
        return !$this->cloturee_le && in_array($this->etat, self::ETATS_DE_DEPART[$transition], true);
    }

    public function transmettre(): void
    {
        $this->passerA('transmettre', EtatDemande::Transmise, [
            'date_transmission' => now(),
        ]);
    }

    public function suspendre(string $message): void
    {
        $this->passerA('suspendre', EtatDemande::Suspendue, [
            'message' => $message,
        ]);
    }

    public function approuver(int $montantAccorde, string $dateApprobation): void
    {
        if ($montantAccorde > $this->budget) {
            throw new TransitionInterdite('L\'appui financier accordé est supérieur au budget demandé par l\'artisan.');
        }

        $this->passerA('approuver', EtatDemande::Approuvee, [
            'budget_accorde' => $montantAccorde,
            'date_approbation' => $dateApprobation,
        ]);
    }

    private function passerA(string $transition, EtatDemande $vers, array $champs): void
    {
        if ($this->cloturee_le) {
            throw new TransitionInterdite('Ce dossier appartient à un exercice clôturé.');
        }

        if (!$this->peut($transition)) {
            throw new TransitionInterdite("Action impossible : la demande est « {$this->etat->libelle()} ».");
        }

        $this->update(['etat' => $vers] + $champs);
    }

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
        return $this->belongsTo(Branche::class);
    }

    public function corps()
    {
        return $this->belongsTo(Corp::class);
    }

    public function metier()
    {
        return $this->belongsTo(Metier::class);
    }

    public function localisations()
    {
        return $this->hasMany(DemandeLocalisation::class);
    }
}
