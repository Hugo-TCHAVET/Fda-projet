<?php

namespace Tests\Feature;

use App\Models\Demande;
use App\Enums\EtatDemande;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Concerns\CreeDonneesReference;
use Tests\TestCase;

class ModificationDemandeTest extends TestCase
{
    use RefreshDatabase;
    use CreeDonneesReference;

    private Demande $demande;

    protected function setUp(): void
    {
        parent::setUp();
        $this->creerDonneesReference();
        $this->demande = $this->creerDemande([
            'structure' => 'Structure d origine',
            'etat' => EtatDemande::Transmise,
            'budget_accorde' => '0',
            'rapport_fichier' => null,
        ]);
        $this->actingAs(User::factory()->create(['role' => 'secretaire']));
    }

    public function test_modification_ignore_champs_hors_formulaire(): void
    {
        $this->put(route('update.demande', $this->demande->id), AccesDemandesTest::chargeUtileDemande() + [
            'etat' => 'approuvee',
            'cloturee_le' => '2026-01-01 00:00:00',
            'budget_accorde' => '999999',
            'rapport_fichier' => 'secret.txt',
        ]);

        $demande = $this->demande->fresh();
        $this->assertSame('Atelier Test', $demande->structure);
        $this->assertSame(EtatDemande::Transmise, $demande->etat);
        $this->assertNull($demande->cloturee_le);
        $this->assertSame('0', (string) $demande->budget_accorde);
        $this->assertNull($demande->rapport_fichier);
    }

    public function test_modification_enregistre_champs_et_localisations(): void
    {
        $this->put(route('update.demande', $this->demande->id), AccesDemandesTest::chargeUtileDemande() + [
            'localisations' => [
                ['departement_id' => 1, 'commune_id' => 1, 'lieux' => 'Cotonou', 'homme_touche' => 12],
            ],
        ]);

        $this->assertSame('Atelier Test', $this->demande->fresh()->structure);
        $localisations = $this->demande->localisations()->get();
        $this->assertCount(1, $localisations);
        $this->assertSame(1, (int) $localisations[0]->departement_id);
        $this->assertSame(1, (int) $localisations[0]->commune_id);
        $this->assertSame('Cotonou', $localisations[0]->lieux);
        $this->assertSame(12, (int) $localisations[0]->homme_touche);
    }
}
