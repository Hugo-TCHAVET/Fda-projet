<?php

namespace App\Support;

use Illuminate\Support\Facades\DB;

/**
 * Clears reference values that a foreign key would reject: empty strings, non-numeric values and ids missing from the reference table.
 */
class Orphelins
{
    /** @return array<int, array{0: int, 1: string, 2: string}> the orphans found, as [row id, column, old value] */
    public static function neutraliser(string $table, string $colonne, string $tableReference): array
    {
        DB::table($table)->whereNotNull($colonne)->update([$colonne => DB::raw("TRIM({$colonne})")]);
        DB::table($table)->where($colonne, '')->update([$colonne => null]);

        // MySQL casts '2abc' to 2 when comparing with an integer id: non-numeric values must be caught first.
        $orphelins = DB::table($table)
            ->whereNotNull($colonne)
            ->where(fn ($requete) => $requete
                ->where($colonne, 'NOT REGEXP', '^[0-9]+$')
                ->orWhereNotIn($colonne, DB::table($tableReference)->select('id')))
            ->orderBy('id')
            ->get(['id', $colonne])
            ->map(fn ($ligne) => [$ligne->id, $colonne, $ligne->{$colonne}])
            ->all();

        DB::table($table)->whereIn('id', array_column($orphelins, 0))->update([$colonne => null]);

        return $orphelins;
    }
}
