<?php

namespace Tests\Feature;

use App\Enums\EtatDemande;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Concerns\CreeDonneesReference;
use Tests\TestCase;

class LibellesEtatTest extends TestCase
{
    use RefreshDatabase;
    use CreeDonneesReference;

    protected function setUp(): void
    {
        parent::setUp();
        $this->creerDonneesReference();
    }

    public function test_suivi_affiche_le_libelle_de_l_etat(): void
    {
        $this->creerDemande(['etat' => EtatDemande::Transmise]);
        $this->creerDemande(['etat' => EtatDemande::Suspendue]);
        $this->creerDemande(['etat' => EtatDemande::Approuvee]);

        $this->actingAs(User::factory()->create(['role' => 'directeur']))
            ->get(route('suivi.demandes'))
            ->assertSee('En cours de traitement')
            ->assertSee('Suspendue')
            ->assertSee('Approuvée')
            ->assertDontSee('Rejété');
    }

    public function test_listes_affichent_le_libelle_de_l_etat(): void
    {
        $this->creerDemande(['etat' => EtatDemande::EnAttente]);

        $this->actingAs(User::factory()->create(['role' => 'secretaire']))
            ->get(route('liste.demande'))
            ->assertSee('En attente');
    }
}
