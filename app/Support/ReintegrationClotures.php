<?php

namespace App\Support;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use RuntimeException;

/**
 * Moves closed demandes from the demandes_clotures copy back into demandes, keeping their original id.
 */
class ReintegrationClotures
{
    private const COLONNES_DE_CLOTURE = ['id', 'demande_id_original', 'annee_exercice_cloture', 'date_cloture', 'user_id_cloture'];

    /**
     * @return array{demandes: int, localisations: int}
     */
    public static function executer(): array
    {
        $conflits = DB::table('demandes_clotures')
            ->whereIn('demande_id_original', DB::table('demandes')->select('id'))
            ->pluck('demande_id_original');

        if ($conflits->isNotEmpty()) {
            throw new RuntimeException('Réintégration arrêtée : identifiants déjà présents dans demandes : '.$conflits->implode(', '));
        }

        $colonnesCommunes = array_values(array_diff(
            array_intersect(Schema::getColumnListing('demandes_clotures'), Schema::getColumnListing('demandes')),
            self::COLONNES_DE_CLOTURE
        ));
        $utilisateurs = DB::table('users')->pluck('id')->flip();

        return DB::transaction(function () use ($colonnesCommunes, $utilisateurs) {
            $demandes = 0;
            foreach (DB::table('demandes_clotures')->orderBy('id')->cursor() as $cloture) {
                $ligne = array_intersect_key((array) $cloture, array_flip($colonnesCommunes));

                DB::table('demandes')->insert($ligne + [
                    'id' => $cloture->demande_id_original,
                    'etat' => MigrationEtat::depuisDrapeaux($cloture->valide, $cloture->suspendre)->value,
                    'exercice' => $cloture->annee_exercice_cloture,
                    'cloturee_le' => $cloture->date_cloture,
                    'cloturee_par' => $utilisateurs->has($cloture->user_id_cloture) ? $cloture->user_id_cloture : null,
                ]);
                $demandes++;
            }

            // Old localisation ids may already be taken in demande_localisations: let the table assign new ones.
            $localisations = DB::table('demande_localisations')->insertUsing(
                ['demande_id', 'departement_id', 'commune_id', 'lieux', 'homme_touche', 'created_at', 'updated_at'],
                DB::table('demande_localisations_clotures')
                    ->select('demande_id_original', 'departement_id', 'commune_id', 'lieux', 'homme_touche', 'created_at', 'updated_at')
            );

            return ['demandes' => $demandes, 'localisations' => $localisations];
        });
    }
}
