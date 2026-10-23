<?php

namespace App\Services;

use App\Enums\EtatDemande;
use App\Models\Demande;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

/**
 * Closing a fiscal year closes its approved allocations and carries every other open demande to the next year.
 */
class ClotureExercice
{
    /**
     * @return array{cloturees: int, reportees: int, montant_accorde: int}
     */
    public static function apercu(int $annee): array
    {
        $allocations = self::allocations($annee)->pluck('budget_accorde');

        return [
            'cloturees' => $allocations->count(),
            'reportees' => self::aReporter($annee)->count(),
            'montant_accorde' => (int) $allocations->sum(),
        ];
    }

    /**
     * @return array{cloturees: int, reportees: int}
     */
    public static function cloturer(int $annee, User $par): array
    {
        return DB::transaction(fn () => [
            'cloturees' => self::allocations($annee)->update(['cloturee_le' => now(), 'cloturee_par' => $par->id]),
            'reportees' => self::aReporter($annee)->update(['exercice' => $annee + 1]),
        ]);
    }

    private static function allocations(int $annee): Builder
    {
        return Demande::enCours()->allocations()->where('exercice', $annee);
    }

    private static function aReporter(int $annee): Builder
    {
        return Demande::enCours()->where('exercice', $annee)->where('etat', '!=', EtatDemande::Approuvee->value);
    }
}
