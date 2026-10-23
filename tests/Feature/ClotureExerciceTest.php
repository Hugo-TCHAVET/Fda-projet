<?php

namespace Tests\Feature;

use App\Enums\EtatDemande;
use App\Http\Livewire\DemandeApprouve;
use App\Models\Demande;
use App\Models\User;
use App\Services\ClotureExercice;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\Concerns\CreeDonneesReference;
use Tests\TestCase;

class ClotureExerciceTest extends TestCase
{
    use RefreshDatabase;
    use CreeDonneesReference;

    private User $verificateur;
    private Demande $approuvee;
    private Demande $enAttente;
    private Demande $suspendue;
    private Demande $dejaCloturee;

    protected function setUp(): void
    {
        parent::setUp();
        $this->creerDonneesReference();
        $this->verificateur = User::factory()->create(['role' => 'verificateur']);

        $this->approuvee = $this->creerDemande(['exercice' => 2025, 'etat' => EtatDemande::Approuvee, 'budget_accorde' => '700000']);
        $this->enAttente = $this->creerDemande(['exercice' => 2025, 'etat' => EtatDemande::EnAttente, 'budget' => '900000']);
        $this->suspendue = $this->creerDemande(['exercice' => 2025, 'etat' => EtatDemande::Suspendue]);
        $this->dejaCloturee = $this->creerDemande(['exercice' => 2025, 'etat' => EtatDemande::Approuvee, 'cloturee_le' => '2025-12-31 10:00:00']);
    }

    public function test_cloture_marque_les_allocations_approuvees(): void
    {
        $resultat = ClotureExercice::cloturer(2025, $this->verificateur);

        $this->assertSame(1, $resultat['cloturees']);
        $this->assertNotNull($this->approuvee->fresh()->cloturee_le);
        $this->assertSame($this->verificateur->id, (int) $this->approuvee->fresh()->cloturee_par);
        $this->assertSame('2025-12-31 10:00:00', $this->dejaCloturee->fresh()->cloturee_le->format('Y-m-d H:i:s'));
    }

    public function test_cloture_reporte_les_autres_demandes(): void
    {
        $resultat = ClotureExercice::cloturer(2025, $this->verificateur);

        $this->assertSame(2, $resultat['reportees']);
        foreach ([$this->enAttente, $this->suspendue] as $demande) {
            $this->assertSame(2026, $demande->fresh()->exercice);
            $this->assertNull($demande->fresh()->cloturee_le);
        }
        $this->assertSame(EtatDemande::Suspendue, $this->suspendue->fresh()->etat);
    }

    public function test_cloture_idempotente(): void
    {
        ClotureExercice::cloturer(2025, $this->verificateur);

        $this->assertSame(['cloturees' => 0, 'reportees' => 0], ClotureExercice::cloturer(2025, $this->verificateur));
    }

    public function test_demande_reportee_cloturee_avec_l_exercice_suivant(): void
    {
        ClotureExercice::cloturer(2025, $this->verificateur);
        $reportee = $this->enAttente->fresh();
        $reportee->transmettre();
        $reportee->approuver(500000, '2026-03-01');

        ClotureExercice::cloturer(2026, $this->verificateur);

        $this->assertNotNull($reportee->fresh()->cloturee_le);
        $this->assertSame(2026, $reportee->fresh()->exercice);
    }

    public function test_apercu_sans_effet(): void
    {
        $apercu = ClotureExercice::apercu(2025);

        $this->assertSame(['cloturees' => 1, 'reportees' => 2, 'montant_accorde' => 700000], $apercu);
        $this->assertNull($this->approuvee->fresh()->cloturee_le);
        $this->assertSame(2025, $this->enAttente->fresh()->exercice);
    }

    public function test_cloture_refusee_a_un_autre_verificateur(): void
    {
        $this->actingAs($this->verificateur);

        Livewire::test(DemandeApprouve::class)
            ->set('annee_cloture', 2025)
            ->call('cloturerExercice');

        $this->assertNull($this->approuvee->fresh()->cloturee_le);
        $this->assertSame(2025, $this->enAttente->fresh()->exercice);
    }

    public function test_cloture_depuis_l_ecran(): void
    {
        $this->actingAs(User::factory()->create(['role' => 'verificateur', 'email' => 'sese@apps.fda.bj']));

        Livewire::test(DemandeApprouve::class)
            ->call('openClotureModal')
            ->set('annee_cloture', 2025)
            ->assertSet('nbDemandesACloturer', 1)
            ->assertSet('nbDemandesAReporter', 2)
            ->call('cloturerExercice');

        $this->assertNotNull($this->approuvee->fresh()->cloturee_le);
        $this->assertSame(2026, $this->enAttente->fresh()->exercice);
    }

    public function test_modale_annonce_le_report_des_demandes_non_approuvees(): void
    {
        $this->actingAs($this->verificateur);

        Livewire::test(DemandeApprouve::class)
            ->call('openClotureModal')
            ->assertDontSee('toutes les demandes de l\'année', false)
            ->assertSee('reportées sur l\'exercice suivant', false);
    }
}
