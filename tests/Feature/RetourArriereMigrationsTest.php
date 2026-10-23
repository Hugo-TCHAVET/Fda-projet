<?php

namespace Tests\Feature;

use RuntimeException;
use Tests\TestCase;

class RetourArriereMigrationsTest extends TestCase
{
    /**
     * @dataProvider migrationsSansRetour
     */
    public function test_retour_arriere_refuse(string $fichier): void
    {
        $migration = require database_path("migrations/{$fichier}.php");

        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('sauvegarde');

        $migration->down();
    }

    public static function migrationsSansRetour(): array
    {
        return [
            'réintégration des clôtures' => ['2026_10_23_100000_reintegrate_closed_demandes'],
            'suppression des colonnes d\'état' => ['2026_10_23_200000_drop_legacy_state_columns'],
        ];
    }
}
