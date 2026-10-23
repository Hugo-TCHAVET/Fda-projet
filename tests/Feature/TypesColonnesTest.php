<?php

namespace Tests\Feature;

use App\Enums\EtatDemande;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\Concerns\CreeDonneesReference;
use Tests\TestCase;

class TypesColonnesTest extends TestCase
{
    use RefreshDatabase;
    use CreeDonneesReference;

    private const TYPES = [
        'budget' => 'bigint unsigned',
        'budget_accorde' => 'bigint unsigned',
        'homme_touche' => 'int unsigned',
        'duree_activite' => 'smallint unsigned',
        'debut_activite' => 'date',
        'fin_activite' => 'date',
    ];

    public function test_types_des_colonnes(): void
    {
        $types = DB::table('information_schema.columns')
            ->where('table_schema', DB::getDatabaseName())
            ->where('table_name', 'demandes')
            ->whereIn('column_name', array_keys(self::TYPES))
            ->selectRaw('column_name as colonne, column_type as type')
            ->pluck('type', 'colonne')
            ->all();

        ksort($types);
        $attendus = self::TYPES;
        ksort($attendus);
        $this->assertSame($attendus, $types);
    }

    public function test_montants_lus_comme_entiers(): void
    {
        $this->creerDonneesReference();
        $demande = $this->creerDemande(['budget' => '1500000', 'budget_accorde' => '250000', 'homme_touche' => '12', 'duree_activite' => '7']);

        $demande = $demande->fresh();
        $this->assertSame(1500000, $demande->budget);
        $this->assertSame(250000, $demande->budget_accorde);
        $this->assertSame(12, $demande->homme_touche);
        $this->assertSame(7, $demande->duree_activite);
    }

    /**
     * @dataProvider montantsRefuses
     */
    public function test_creation_refuse_un_montant_non_entier(string $budget): void
    {
        $this->actingAs(User::factory()->create(['role' => 'secretaire']))
            ->post(route('demande.store'), ['budget' => $budget] + AccesDemandesTest::chargeUtileDemande())
            ->assertSessionHasErrors('budget');

        $this->assertDatabaseCount('demandes', 0);
    }

    public static function montantsRefuses(): array
    {
        return ['décimal' => ['1500.5'], 'négatif' => ['-5'], 'notation scientifique' => ['1e6']];
    }

    public function test_approbation_refuse_un_montant_decimal(): void
    {
        $this->creerDonneesReference();
        $demande = $this->creerDemande(['etat' => EtatDemande::Transmise, 'budget' => '800000']);

        $this->actingAs(User::factory()->create(['role' => 'verificateur']))
            ->post(route('demande.prixbudget', $demande->id), ['budget_accorde' => '1000.5', 'date_approbation' => '2026-10-01'])
            ->assertSessionHasErrors('budget_accorde');

        $this->assertSame(EtatDemande::Transmise, $demande->fresh()->etat);
    }

    /**
     * @dataProvider dureesRefusees
     */
    public function test_modification_refuse_une_duree_hors_plage(string $duree): void
    {
        $this->creerDonneesReference();
        $demande = $this->creerDemande(['duree_activite' => '7']);

        $this->actingAs(User::factory()->create(['role' => 'secretaire']))
            ->put(route('update.demande', $demande->id), ['duree_activite' => $duree] + AccesDemandesTest::chargeUtileDemande())
            ->assertSessionHasErrors('duree_activite');

        $this->assertSame(7, (int) $demande->fresh()->duree_activite);
    }

    public static function dureesRefusees(): array
    {
        return ['négative' => ['-3'], 'au-delà d\'un smallint' => ['70000']];
    }

    public function test_creation_refuse_un_effectif_hors_plage(): void
    {
        $this->creerDonneesReference();

        $this->actingAs(User::factory()->create(['role' => 'secretaire']))
            ->post(route('demande.store'), AccesDemandesTest::chargeUtileDemande() + [
                'duree_activite' => '70000',
                'localisations' => [['departement_id' => 1, 'commune_id' => 1, 'lieux' => 'Cotonou', 'homme_touche' => '3000000000']],
            ])
            ->assertSessionHasErrors(['duree_activite', 'localisations.0.homme_touche']);

        $this->assertDatabaseCount('demandes', 0);
    }
}
