<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // Definitions copied from the production dump (basefda.sql); on production this migration changes nothing.
    private const COLONNES = [
        'demandes' => [
            'archivee' => 'TINYINT(1) NULL DEFAULT 0',
            'buget_prevu' => "VARCHAR(255) NULL DEFAULT '0'",
            'commune' => 'VARCHAR(255) NULL',
            'contact' => 'VARCHAR(255) NULL',
            'debut_activite' => 'VARCHAR(255) NULL',
            'departement' => 'VARCHAR(255) NULL',
            'dure_activite' => 'VARCHAR(255) NULL',
            'fin_activite' => 'VARCHAR(255) NULL',
            'homme_touche' => 'VARCHAR(255) NULL',
            'lieux' => 'VARCHAR(255) NULL',
            'piece' => 'VARCHAR(255) NULL',
            'rapport_depose' => 'TINYINT(1) NULL DEFAULT 0',
            'rejeter' => "VARCHAR(255) NULL DEFAULT '0'",
            'suspendre' => "VARCHAR(255) NULL DEFAULT '0'",
            'valide' => "VARCHAR(255) NULL DEFAULT '0'",
        ],
        'demandes_clotures' => [
            'archivee' => 'TINYINT(1) NULL DEFAULT 0',
            'buget_prevu' => "VARCHAR(255) NULL DEFAULT '0'",
            'rapport_depose' => 'TINYINT(1) NULL DEFAULT 0',
            'rejeter' => "VARCHAR(255) NULL DEFAULT '0'",
            'status' => "VARCHAR(255) NULL DEFAULT 'En attente'",
            'suspendre' => "VARCHAR(255) NULL DEFAULT '0'",
            'valide' => "VARCHAR(255) NULL DEFAULT '0'",
        ],
        'demande_localisations' => [
            'homme_touche' => 'INT NULL',
        ],
        'demande_localisations_clotures' => [
            'commune_id' => 'BIGINT UNSIGNED NULL',
            'departement_id' => 'BIGINT UNSIGNED NULL',
            'homme_touche' => 'INT NULL',
            'lieux' => 'VARCHAR(255) NULL',
        ],
    ];

    public function up()
    {
        foreach (self::COLONNES as $table => $colonnes) {
            $modifications = collect($colonnes)
                ->map(fn ($definition, $colonne) => "MODIFY `{$colonne}` {$definition}")
                ->implode(', ');

            DB::statement("ALTER TABLE `{$table}` {$modifications}");
        }

        if (Schema::hasColumn('demandes', 'femme_touche')) {
            Schema::table('demandes', function (Blueprint $table) {
                $table->dropColumn('femme_touche');
            });
        }
    }

    // Going back to NOT NULL would fail on production data, which already holds NULLs.
    public function down()
    {
    }
};
