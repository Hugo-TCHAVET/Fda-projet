<?php

use App\Support\AuditDemandes;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    // Column names as they are at this point of the history: later renames must not leak in here.
    private const CONVERSIONS = [
        'budget' => 'montant',
        'buget_prevu' => 'montant',
        'homme_touche' => 'entier:4294967295',
        'dure_activite' => 'entier:65535',
        'debut_activite' => 'date',
        'fin_activite' => 'date',
    ];

    private const TYPES = [
        'budget' => 'BIGINT UNSIGNED NOT NULL',
        'buget_prevu' => 'BIGINT UNSIGNED NULL DEFAULT 0',
        'homme_touche' => 'INT UNSIGNED NULL',
        'dure_activite' => 'SMALLINT UNSIGNED NULL',
        'debut_activite' => 'DATE NULL',
        'fin_activite' => 'DATE NULL',
    ];

    public function up()
    {
        // MySQL DDL commits implicitly: every row must convert before the first ALTER.
        $anomalies = AuditDemandes::conversions(self::CONVERSIONS);
        if ($anomalies !== []) {
            throw new RuntimeException(count($anomalies).' valeur(s) non convertible(s) : lancer php artisan fda:audit-donnees et les corriger avant la migration.');
        }

        DB::transaction(function () {
            DB::table('demandes')->select(['id', ...array_keys(self::CONVERSIONS)])->orderBy('id')
                ->chunk(500, function ($lignes) {
                    foreach ($lignes as $ligne) {
                        $valeurs = [];
                        foreach (self::CONVERSIONS as $colonne => $type) {
                            $valeurs[$colonne] = AuditDemandes::normaliser($type, $ligne->{$colonne});
                        }
                        DB::table('demandes')->where('id', $ligne->id)->update($valeurs);
                    }
                });
        });

        foreach (self::TYPES as $colonne => $definition) {
            DB::statement("ALTER TABLE demandes MODIFY {$colonne} {$definition}");
        }
    }

    public function down()
    {
        foreach (array_keys(self::TYPES) as $colonne) {
            $nullable = $colonne === 'budget' ? 'NOT NULL' : 'NULL';
            $defaut = $colonne === 'buget_prevu' ? " DEFAULT '0'" : '';
            DB::statement("ALTER TABLE demandes MODIFY {$colonne} VARCHAR(255) {$nullable}{$defaut}");
        }
    }
};
