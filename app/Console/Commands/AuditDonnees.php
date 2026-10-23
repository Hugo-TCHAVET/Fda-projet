<?php

namespace App\Console\Commands;

use App\Support\AuditDemandes;
use Illuminate\Console\Command;

class AuditDonnees extends Command
{
    protected $signature = 'fda:audit-donnees';

    protected $description = 'Liste les valeurs non convertibles et les références orphelines des demandes';

    public function handle(): int
    {
        $anomalies = [...AuditDemandes::conversions(), ...AuditDemandes::references()];
        usort($anomalies, fn ($a, $b) => $a[0] <=> $b[0]);

        if ($anomalies === []) {
            $this->info('Aucune anomalie.');

            return self::SUCCESS;
        }

        $this->table(['Demande', 'Colonne', 'Valeur', 'Problème'], $anomalies);
        $this->error(count($anomalies).' anomalie(s).');

        return self::FAILURE;
    }
}
