<?php

namespace Tests\Feature;

use App\Support\AuditDemandes;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\Concerns\CreeDonneesReference;
use Tests\TestCase;

class AuditDonneesTest extends TestCase
{
    use RefreshDatabase;
    use CreeDonneesReference;

    protected function setUp(): void
    {
        parent::setUp();
        $this->creerDonneesReference();
    }

    public function test_donnees_propres(): void
    {
        $this->creerDemande(['budget' => 1500000, 'departement' => '1', 'commune' => '1', 'debut_activite' => '2026-10-05']);

        $this->artisan('fda:audit-donnees')->expectsOutputToContain('Aucune anomalie')->assertExitCode(0);
    }

    public function test_audit_signale_departement_orphelin(): void
    {
        $this->creerDemande(['departement' => '999', 'commune' => '1']);

        $this->artisan('fda:audit-donnees')
            ->expectsOutputToContain('Aucune ligne departements avec cet identifiant')
            ->assertExitCode(1);
    }

    // The audit runs on a production copy before migrating: text columns, pre-rename names. Rebuilt in a temporary table (no implicit commit).
    public function test_audit_signale_les_valeurs_non_convertibles_avant_migration(): void
    {
        DB::statement('CREATE TEMPORARY TABLE demandes_texte (id INT, budget VARCHAR(255), buget_prevu VARCHAR(255), homme_touche VARCHAR(255), dure_activite VARCHAR(255), debut_activite VARCHAR(255), fin_activite VARCHAR(255))');
        DB::table('demandes_texte')->insert([
            ['id' => 1, 'budget' => '1 500 000', 'buget_prevu' => '', 'homme_touche' => '12', 'dure_activite' => '70000', 'debut_activite' => '05/10/2026', 'fin_activite' => '2026-10-12'],
            ['id' => 2, 'budget' => 'cinq cents', 'buget_prevu' => null, 'homme_touche' => 'douze', 'dure_activite' => '3', 'debut_activite' => '31/02/2026', 'fin_activite' => null],
            ['id' => 3, 'budget' => '', 'buget_prevu' => '250000.00', 'homme_touche' => null, 'dure_activite' => null, 'debut_activite' => null, 'fin_activite' => null],
        ]);

        $anomalies = collect(AuditDemandes::conversions(table: 'demandes_texte'))->map(fn ($a) => [$a[0], $a[1]])->all();

        $this->assertSame([[1, 'dure_activite'], [2, 'budget'], [2, 'homme_touche'], [2, 'debut_activite'], [3, 'budget'], [3, 'buget_prevu']], $anomalies);
    }
}
