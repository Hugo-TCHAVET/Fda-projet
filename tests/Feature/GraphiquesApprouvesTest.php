<?php

namespace Tests\Feature;

use App\Enums\EtatDemande;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\View;
use Tests\Concerns\CreeDonneesReference;
use Tests\TestCase;

class GraphiquesApprouvesTest extends TestCase
{
    use RefreshDatabase;
    use CreeDonneesReference;

    private array $donnees = [];

    protected function setUp(): void
    {
        parent::setUp();
        $this->creerDonneesReference();

        $this->creerDemande(['etat' => EtatDemande::Approuvee, 'branche_id' => 1, 'departement' => '1', 'effectif_homme_forme' => 10, 'effectif_femme_forme' => 20]);
        $this->creerDemande(['etat' => EtatDemande::Approuvee, 'branche_id' => null, 'departement' => null, 'effectif_homme_forme' => 3, 'effectif_femme_forme' => 4]);
        $this->creerDemande(['etat' => EtatDemande::Transmise, 'branche_id' => 1, 'departement' => '1', 'effectif_homme_forme' => 100, 'effectif_femme_forme' => 100]);

        View::composer('Statistique.index', function ($vue) {
            $this->donnees = $vue->getData();
        });
        $this->actingAs(User::factory()->create(['role' => 'directeur']))
            ->get(route('statistiques.admin'))
            ->assertOk();
    }

    private function parNom(string $graphique, string $valeur): array
    {
        return collect($this->donnees[$graphique])->mapWithKeys(fn ($ligne) => [$ligne->nom => (int) $ligne->{$valeur}])->all();
    }

    public function test_g6_exclut_non_approuvees(): void
    {
        $this->assertSame(['Bois' => 1, 'Non renseigné' => 1], $this->parNom('g6_branche_approuves', 'count'));
    }

    public function test_g6_branche_non_renseignee(): void
    {
        $this->assertSame(1, $this->parNom('g6_branche_approuves', 'count')['Non renseigné'] ?? null);
    }

    public function test_g17_exclut_non_approuvees(): void
    {
        $this->assertSame(10, $this->parNom('g17_homme_femme', 'homme')['Atlantique']);
        $this->assertSame(20, $this->parNom('g17_homme_femme', 'femme')['Atlantique']);
    }

    public function test_g17_departement_non_renseigne_conserve(): void
    {
        $this->assertSame(3, $this->parNom('g17_homme_femme', 'homme')['Non renseigné'] ?? null);
        $this->assertSame(4, $this->parNom('g17_homme_femme', 'femme')['Non renseigné'] ?? null);
    }

    public function test_g16_exclut_non_approuvees(): void
    {
        $this->assertSame(30, $this->parNom('g16_prevu_vs_touche', 'touche')['Atlantique']);
    }
}
