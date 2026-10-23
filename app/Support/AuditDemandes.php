<?php

namespace App\Support;

use Illuminate\Support\Facades\DB;

/**
 * Finds demandes values that cannot be converted to typed columns or that point to missing reference rows.
 * Each anomaly is [demande id, column, value, problem].
 */
class AuditDemandes
{
    public const CONVERSIONS = [
        'budget' => 'montant',
        'budget_accorde' => 'montant',
        'homme_touche' => 'entier:4294967295',
        'duree_activite' => 'entier:65535',
        'debut_activite' => 'date',
        'fin_activite' => 'date',
    ];

    private const OBLIGATOIRES = ['budget'];

    // branche_id, corps_id and metier_id are guarded by foreign keys.
    private const REFERENCES = [
        'departement' => 'departements',
        'commune' => 'communes',
    ];

    // A conversion is "montant", "date" or "entier:<maximum of the target column>".
    public static function normaliser(string $conversion, mixed $valeur): int|string|null
    {
        [$type, $maximum] = array_pad(explode(':', $conversion), 2, null);

        return $maximum === null ? Normalisation::$type($valeur) : Normalisation::$type($valeur, (int) $maximum);
    }

    // The audit is meant to run on a production copy before migrating, when these columns still have their old names.
    private const ANCIENS_NOMS = ['budget_accorde' => 'buget_prevu', 'duree_activite' => 'dure_activite'];

    /** @return array<string, string> CONVERSIONS keyed by the column names the table has today */
    public static function conversionsDuSchema(string $table = 'demandes'): array
    {
        $existantes = array_column(DB::select("SHOW COLUMNS FROM `{$table}`"), 'Field');
        $conversions = [];
        foreach (self::CONVERSIONS as $colonne => $type) {
            $nom = in_array($colonne, $existantes, true) ? $colonne : (self::ANCIENS_NOMS[$colonne] ?? $colonne);
            $conversions[$nom] = $type;
        }

        return $conversions;
    }

    /** @return array<int, array{0: int, 1: string, 2: mixed, 3: string}> */
    public static function conversions(?array $colonnes = null, string $table = 'demandes'): array
    {
        $colonnes ??= self::conversionsDuSchema($table);
        $anomalies = [];

        foreach (DB::table($table)->select(['id', ...array_keys($colonnes)])->orderBy('id')->cursor() as $demande) {
            foreach ($colonnes as $colonne => $type) {
                try {
                    if (self::normaliser($type, $demande->{$colonne}) === null && in_array($colonne, self::OBLIGATOIRES, true)) {
                        throw new ValeurInvalide('Valeur obligatoire manquante');
                    }
                } catch (ValeurInvalide $e) {
                    $anomalies[] = [$demande->id, $colonne, $demande->{$colonne}, $e->getMessage()];
                }
            }
        }

        return $anomalies;
    }

    /** @return array<int, array{0: int, 1: string, 2: mixed, 3: string}> */
    public static function references(): array
    {
        $anomalies = [];
        $existants = collect(self::REFERENCES)->map(fn ($table) => DB::table($table)->pluck('id')->flip());

        foreach (DB::table('demandes')->select(['id', ...array_keys(self::REFERENCES)])->orderBy('id')->cursor() as $demande) {
            foreach (self::REFERENCES as $colonne => $table) {
                $valeur = $demande->{$colonne};
                if ($valeur !== null && $valeur !== '' && !$existants[$colonne]->has((int) $valeur)) {
                    $anomalies[] = [$demande->id, $colonne, $valeur, "Aucune ligne {$table} avec cet identifiant"];
                }
            }
        }

        return $anomalies;
    }
}
