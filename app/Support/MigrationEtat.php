<?php

namespace App\Support;

use App\Enums\EtatDemande;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;

/**
 * Converts the legacy state flags (valide, suspendre) into a single EtatDemande.
 */
class MigrationEtat
{
    // Approval is the later step of the workflow, so it wins over a stale suspension flag.
    public static function depuisDrapeaux(?string $valide, ?string $suspendre): EtatDemande
    {
        if ($valide === '2') {
            return EtatDemande::Approuvee;
        }

        if ($suspendre === '1') {
            return EtatDemande::Suspendue;
        }

        return $valide === '1' ? EtatDemande::Transmise : EtatDemande::EnAttente;
    }

    /**
     * Recomputes etat and exercice from the legacy columns for the given demandes (all by default).
     *
     * @return array{par_etat: array<string, int>, approuvees_suspendues: array<int>}
     */
    public static function remplir(EloquentBuilder|Builder|null $demandes = null): array
    {
        $demandes = $demandes instanceof EloquentBuilder ? $demandes->toBase() : ($demandes ?? DB::table('demandes'));
        $parEtat = [];
        $approuveesSuspendues = [];

        $demandes->select('id', 'valide', 'suspendre', 'created_at')->orderBy('id')
            ->chunk(500, function ($lignes) use (&$parEtat, &$approuveesSuspendues) {
                foreach ($lignes as $ligne) {
                    $etat = self::depuisDrapeaux($ligne->valide, $ligne->suspendre);
                    DB::table('demandes')->where('id', $ligne->id)->update([
                        'etat' => $etat->value,
                        'exercice' => $ligne->created_at ? (int) substr($ligne->created_at, 0, 4) : (int) now()->year,
                    ]);

                    $parEtat[$etat->value] = ($parEtat[$etat->value] ?? 0) + 1;
                    if ($etat === EtatDemande::Approuvee && $ligne->suspendre === '1') {
                        $approuveesSuspendues[] = $ligne->id;
                    }
                }
            });

        return ['par_etat' => $parEtat, 'approuvees_suspendues' => $approuveesSuspendues];
    }
}
