<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Concerns\CreeDonneesReference;
use Tests\TestCase;

class StatistiquesPageTest extends TestCase
{
    use RefreshDatabase;
    use CreeDonneesReference;

    protected function setUp(): void
    {
        parent::setUp();
        $this->creerDonneesReference();
        $this->actingAs(User::factory()->create(['role' => 'directeur']));
    }

    public function test_page_affiche_taux(): void
    {
        $this->creerJeuBeneficiaires();

        $this->get(route('statistiques.admin'))
            ->assertOk()
            ->assertSee('30,0 %')
            ->assertSee('70,0 %')
            ->assertSee('10,0 %')
            ->assertSee('90,0 %')
            ->assertSee('Données handicap non renseignées : 1 rapport(s)');
    }

    public function test_page_affiche_couverture(): void
    {
        $this->creerJeuBeneficiaires();

        $this->get(route('statistiques.admin'))->assertSee('calculé sur 2 rapports / 3 allocations');
    }

    public function test_couverture_handicap_ne_compte_que_les_rapports_renseignes(): void
    {
        $this->creerJeuBeneficiaires();

        $this->get(route('statistiques.admin'))->assertSee('Taux handicap calculé sur 1 rapport(s) renseigné(s) / 3 allocations');
    }

    public function test_page_sans_rapport_affiche_nd(): void
    {
        $this->get(route('statistiques.admin'))
            ->assertOk()
            ->assertSee('n/d');
    }

    public function test_page_affiche_repartition_par_branche(): void
    {
        $this->creerJeuBeneficiaires();

        $this->get(route('statistiques.admin'))->assertSeeInOrder(['Bois', '10', '30', '40', 'Métal', '5', '5', '10']);
    }

    public function test_g9_retire(): void
    {
        $this->get(route('statistiques.admin'))->assertDontSee('g6g9Chart');
    }
}
