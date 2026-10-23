<?php

namespace App\Services;

use App\Enums\EtatDemande;
use App\Models\Demande;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use InvalidArgumentException;

/**
 * Indicateurs sur les bénéficiaires (personnes formées déclarées au rapport post-appui) des allocations approuvées.
 */
class StatistiquesBeneficiaires
{
    private const DIMENSIONS = ['branche' => 'branche_id', 'service' => 'service'];

    public function __construct(private Builder $base)
    {
    }

    public static function pourDemandes(): self
    {
        return new self(Demande::query());
    }

    public function couverture(): array
    {
        $ligne = $this->allocations()
            ->selectRaw('COUNT(*) as allocations, COALESCE(SUM(' . $this->colonne('rapport_depose') . ' = 1), 0) as rapports')
            ->first();

        return ['allocations' => (int) $ligne->allocations, 'rapports' => (int) $ligne->rapports];
    }

    public function repartition(string $dimension): Collection
    {
        if (!array_key_exists($dimension, self::DIMENSIONS)) {
            throw new InvalidArgumentException("Dimension inconnue : {$dimension}");
        }

        $cle = $this->colonne(self::DIMENSIONS[$dimension]);
        $rapport = $this->colonne('rapport_depose') . ' = 1';
        $query = $this->allocations()
            ->selectRaw("{$cle} as cle, COUNT(*) as allocations, SUM({$rapport}) as rapports")
            ->selectRaw("SUM(CASE WHEN {$rapport} THEN COALESCE({$this->colonne('effectif_homme_forme')}, 0) ELSE 0 END) as hommes")
            ->selectRaw("SUM(CASE WHEN {$rapport} THEN COALESCE({$this->colonne('effectif_femme_forme')}, 0) ELSE 0 END) as femmes")
            ->groupBy($cle);

        if ($dimension === 'branche') {
            $query->leftJoin('branches', 'branches.id', '=', $cle)
                ->addSelect('branches.nom as nom_branche')
                ->groupBy('branches.nom');
        }

        return $query->toBase()->get()
            ->groupBy(fn ($ligne) => $this->libelle($dimension, $ligne))
            ->map(function (Collection $lignes, string $libelle) {
                $hommes = (int) $lignes->sum('hommes');
                $femmes = (int) $lignes->sum('femmes');

                return [
                    'libelle' => $libelle,
                    'allocations' => (int) $lignes->sum('allocations'),
                    'rapports' => (int) $lignes->sum('rapports'),
                    'hommes' => $hommes,
                    'femmes' => $femmes,
                    'total' => $hommes + $femmes,
                ];
            })
            ->sortByDesc('total')
            ->values();
    }

    public function parSexe(): array
    {
        $ligne = $this->rapports()
            ->selectRaw('COALESCE(SUM(' . $this->colonne('effectif_homme_forme') . '), 0) as hommes')
            ->selectRaw('COALESCE(SUM(' . $this->colonne('effectif_femme_forme') . '), 0) as femmes')
            ->toBase()
            ->first();

        $hommes = (int) $ligne->hommes;
        $femmes = (int) $ligne->femmes;
        $total = $hommes + $femmes;

        return [
            'hommes' => $hommes,
            'femmes' => $femmes,
            'total' => $total,
            'taux_hommes' => $this->taux($hommes, $total),
            'taux_femmes' => $this->taux($femmes, $total),
        ];
    }

    public function parHandicap(): array
    {
        $renseigne = $this->colonne('effectif_handicape_homme') . ' IS NOT NULL';
        $ligne = $this->rapports()
            ->selectRaw("COALESCE(SUM(CASE WHEN {$renseigne} THEN {$this->colonne('effectif_handicape_homme')} + COALESCE({$this->colonne('effectif_handicape_femme')}, 0) END), 0) as handicapes")
            ->selectRaw("COALESCE(SUM(CASE WHEN {$renseigne} THEN COALESCE({$this->colonne('effectif_homme_forme')}, 0) + COALESCE({$this->colonne('effectif_femme_forme')}, 0) END), 0) as total_renseigne")
            ->selectRaw("COALESCE(SUM({$renseigne}), 0) as rapports_renseignes")
            ->selectRaw("COALESCE(SUM(NOT ({$renseigne})), 0) as rapports_non_renseignes")
            ->toBase()
            ->first();

        $handicapes = (int) $ligne->handicapes;
        $total = (int) $ligne->total_renseigne;

        return [
            'handicapes' => $handicapes,
            'non_handicapes' => $total - $handicapes,
            'total_renseigne' => $total,
            'rapports_renseignes' => (int) $ligne->rapports_renseignes,
            'rapports_non_renseignes' => (int) $ligne->rapports_non_renseignes,
            'taux_handicapes' => $this->taux($handicapes, $total),
            'taux_non_handicapes' => $this->taux($total - $handicapes, $total),
        ];
    }

    private function allocations(): Builder
    {
        return (clone $this->base)
            ->where($this->colonne('etat'), EtatDemande::Approuvee->value)
            ->whereNull($this->colonne('cloturee_le'));
    }

    private function rapports(): Builder
    {
        return $this->allocations()->where($this->colonne('rapport_depose'), true);
    }

    private function colonne(string $nom): string
    {
        return $this->base->getModel()->getTable() . '.' . $nom;
    }

    private function libelle(string $dimension, object $ligne): string
    {
        if ($ligne->cle === null) {
            return 'Non renseigné';
        }

        if ($dimension === 'branche') {
            return $ligne->nom_branche;
        }

        return $ligne->cle;
    }

    private function taux(int $part, int $total): ?float
    {
        return $total === 0 ? null : round($part * 100 / $total, 1);
    }
}
