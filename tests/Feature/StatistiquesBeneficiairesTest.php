<?php

namespace Tests\Feature;

use App\Services\StatistiquesBeneficiaires;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use InvalidArgumentException;
use Tests\Concerns\CreeDonneesReference;
use Tests\TestCase;

class StatistiquesBeneficiairesTest extends TestCase
{
    use RefreshDatabase;
    use CreeDonneesReference;

    protected function setUp(): void
    {
        parent::setUp();
        $this->creerDonneesReference();
    }

    public function test_par_sexe(): void
    {
        $this->creerJeuBeneficiaires();

        $this->assertSame(
            ['hommes' => 15, 'femmes' => 35, 'total' => 50, 'taux_hommes' => 30.0, 'taux_femmes' => 70.0],
            StatistiquesBeneficiaires::pourDemandes()->parSexe()
        );
    }

    public function test_ancien_rapport_sans_handicap_exclu_du_taux_handicap(): void
    {
        $this->creerJeuBeneficiaires();

        $this->assertSame([
            'handicapes' => 4,
            'non_handicapes' => 36,
            'total_renseigne' => 40,
            'rapports_renseignes' => 1,
            'rapports_non_renseignes' => 1,
            'taux_handicapes' => 10.0,
            'taux_non_handicapes' => 90.0,
        ], StatistiquesBeneficiaires::pourDemandes()->parHandicap());
    }

    public function test_repartition_par_branche(): void
    {
        $this->creerJeuBeneficiaires();

        $lignes = StatistiquesBeneficiaires::pourDemandes()->repartition('branche')->values()->all();

        $this->assertSame([
            ['libelle' => 'Bois', 'allocations' => 2, 'rapports' => 1, 'hommes' => 10, 'femmes' => 30, 'total' => 40],
            ['libelle' => 'Métal', 'allocations' => 1, 'rapports' => 1, 'hommes' => 5, 'femmes' => 5, 'total' => 10],
        ], $lignes);
    }

    public function test_repartition_par_service(): void
    {
        $this->creerJeuBeneficiaires();

        $totaux = StatistiquesBeneficiaires::pourDemandes()->repartition('service')->pluck('total', 'libelle')->all();

        $this->assertSame(['Formation' => 40, 'Assistance' => 10], $totaux);
    }

    public function test_aucun_rapport_donne_taux_null(): void
    {
        $stats = StatistiquesBeneficiaires::pourDemandes();

        $this->assertSame(['hommes' => 0, 'femmes' => 0, 'total' => 0, 'taux_hommes' => null, 'taux_femmes' => null], $stats->parSexe());
        $handicap = $stats->parHandicap();
        $this->assertSame(0, $handicap['total_renseigne']);
        $this->assertNull($handicap['taux_handicapes']);
        $this->assertNull($handicap['taux_non_handicapes']);
        $this->assertTrue($stats->repartition('branche')->isEmpty());
    }

    public function test_arrondi_une_decimale(): void
    {
        $this->creerAllocation(['effectif_homme_forme' => 1, 'effectif_femme_forme' => 2]);

        $sexe = StatistiquesBeneficiaires::pourDemandes()->parSexe();

        $this->assertSame(33.3, $sexe['taux_hommes']);
        $this->assertSame(66.7, $sexe['taux_femmes']);
    }

    public function test_approuvee_puis_suspendue_reste_comptee(): void
    {
        $this->creerAllocation(['suspendre' => '1', 'effectif_homme_forme' => 2, 'effectif_femme_forme' => 0]);

        $this->assertSame(2, StatistiquesBeneficiaires::pourDemandes()->parSexe()['hommes']);
    }

    public function test_approuvee_sans_statuts_comptee(): void
    {
        $this->creerAllocation(['statuts' => null, 'effectif_homme_forme' => 4, 'effectif_femme_forme' => 0]);

        $this->assertSame(4, StatistiquesBeneficiaires::pourDemandes()->parSexe()['hommes']);
    }

    public function test_dimension_inconnue_refusee(): void
    {
        $this->expectException(InvalidArgumentException::class);

        StatistiquesBeneficiaires::pourDemandes()->repartition('ifu');
    }

    public function test_couverture(): void
    {
        $this->creerJeuBeneficiaires();

        $this->assertSame(['allocations' => 3, 'rapports' => 2], StatistiquesBeneficiaires::pourDemandes()->couverture());
    }

    public function test_branche_inconnue_et_nulle(): void
    {
        $this->creerAllocation(['branche' => '999', 'effectif_homme_forme' => 1, 'effectif_femme_forme' => 0]);
        $this->creerAllocation(['branche' => null, 'effectif_homme_forme' => 0, 'effectif_femme_forme' => 1]);

        $libelles = StatistiquesBeneficiaires::pourDemandes()->repartition('branche')->pluck('libelle')->sort()->values()->all();

        $this->assertSame(['Branche inconnue', 'Non renseigné'], $libelles);
    }

    public function test_ignore_demandes_cloturees(): void
    {
        DB::table('demandes_clotures')->insert([
            'demande_id_original' => 1, 'annee_exercice_cloture' => 2025, 'date_cloture' => now(),
            'code' => 'X', 'structure' => 'S', 'service' => 'Formation', 'type_demande' => 'ONG',
            'nom' => 'N', 'prenom' => 'P', 'sexe' => 'Masculin', 'ifu' => '1', 'titre_activite' => 'T',
            'obejectif_activite' => 'O', 'budget' => '1', 'valide' => '2', 'rapport_depose' => true,
            'effectif_homme_forme' => 50, 'effectif_femme_forme' => 0,
        ]);

        $this->assertSame(0, StatistiquesBeneficiaires::pourDemandes()->parSexe()['hommes']);
    }
}
