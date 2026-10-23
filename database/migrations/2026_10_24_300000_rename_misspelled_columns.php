<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    private const COLONNES = [
        'buget_prevu' => 'budget_accorde',
        'obejectif_activite' => 'objectif_activite',
        'dure_activite' => 'duree_activite',
    ];

    // InnoDB keeps the foreign keys of corps, metiers and demandes pointing at the renamed table.
    public function up()
    {
        DB::statement('RENAME TABLE braches TO branches');

        foreach (self::COLONNES as $avant => $apres) {
            DB::statement("ALTER TABLE demandes RENAME COLUMN {$avant} TO {$apres}");
        }
    }

    public function down()
    {
        foreach (self::COLONNES as $avant => $apres) {
            DB::statement("ALTER TABLE demandes RENAME COLUMN {$apres} TO {$avant}");
        }

        DB::statement('RENAME TABLE branches TO braches');
    }
};
