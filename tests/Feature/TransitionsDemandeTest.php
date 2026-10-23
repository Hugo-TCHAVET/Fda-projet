<?php

namespace Tests\Feature;

use App\Enums\EtatDemande;
use App\Exceptions\TransitionInterdite;
use App\Http\Livewire\DemandeSuspendu;
use App\Http\Livewire\ListeDemande;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\Concerns\CreeDonneesReference;
use Tests\TestCase;

class TransitionsDemandeTest extends TestCase
{
    use RefreshDatabase;
    use CreeDonneesReference;

    protected function setUp(): void
    {
        parent::setUp();
        $this->creerDonneesReference();
    }

    public function test_transmettre(): void
    {
        $demande = $this->creerDemande(['etat' => EtatDemande::EnAttente]);

        $demande->transmettre();

        $demande = $demande->fresh();
        $this->assertSame(EtatDemande::Transmise, $demande->etat);
        $this->assertNotNull($demande->date_transmission);
    }

    public function test_suspendre_enregistre_le_message(): void
    {
        $demande = $this->creerDemande(['etat' => EtatDemande::Transmise]);

        $demande->suspendre('Pièce manquante');

        $this->assertSame(EtatDemande::Suspendue, $demande->fresh()->etat);
        $this->assertSame('Pièce manquante', $demande->fresh()->message);
    }

    public function test_retransmettre_une_suspendue(): void
    {
        $demande = $this->creerDemande(['etat' => EtatDemande::Suspendue]);

        $demande->transmettre();

        $this->assertSame(EtatDemande::Transmise, $demande->fresh()->etat);
    }

    public function test_approuver_renseigne_montant_et_date(): void
    {
        $demande = $this->creerDemande(['etat' => EtatDemande::Transmise, 'budget' => 800000]);

        $demande->approuver(600000, '2026-10-01');

        $demande = $demande->fresh();
        $this->assertSame(EtatDemande::Approuvee, $demande->etat);
        $this->assertSame('600000', (string) $demande->budget_accorde);
        $this->assertSame('2026-10-01', $demande->date_approbation->format('Y-m-d'));
    }

    public function test_transition_interdite_refusee(): void
    {
        $demande = $this->creerDemande(['etat' => EtatDemande::EnAttente]);

        try {
            $demande->approuver(1000, '2026-10-01');
            $this->fail('Une approbation sans transmission doit être refusée.');
        } catch (TransitionInterdite) {
            $this->assertSame(EtatDemande::EnAttente, $demande->fresh()->etat);
        }
    }

    public function test_approbation_superieure_au_montant_demande_refusee(): void
    {
        $demande = $this->creerDemande(['etat' => EtatDemande::Transmise, 'budget' => '500000']);

        $this->expectException(TransitionInterdite::class);
        $demande->approuver(500001, '2026-10-01');
    }

    public function test_dossier_cloture_refuse_toute_transition(): void
    {
        $demande = $this->creerDemande(['etat' => EtatDemande::Transmise, 'cloturee_le' => now()]);

        $this->expectException(TransitionInterdite::class);
        $demande->suspendre('trop tard');
    }

    public function test_transmission_par_la_secretaire(): void
    {
        $demande = $this->creerDemande(['etat' => EtatDemande::EnAttente]);

        $this->actingAs(User::factory()->create(['role' => 'secretaire']))
            ->post(route('demande.transmettre', $demande->id));

        $this->assertSame(EtatDemande::Transmise, $demande->fresh()->etat);
    }

    public function test_suspension_par_le_verificateur(): void
    {
        $demande = $this->creerDemande(['etat' => EtatDemande::Transmise]);

        $this->actingAs(User::factory()->create(['role' => 'verificateur']))
            ->post(route('demande.suspendre', $demande->id), ['message' => 'Pièce manquante']);

        $this->assertSame(EtatDemande::Suspendue, $demande->fresh()->etat);
    }

    public function test_approbation_par_le_verificateur(): void
    {
        $demande = $this->creerDemande(['etat' => EtatDemande::Transmise, 'budget' => '800000']);

        $this->actingAs(User::factory()->create(['role' => 'verificateur']))
            ->post(route('demande.prixbudget', $demande->id), ['budget_accorde' => 600000, 'date_approbation' => '2026-10-01']);

        $this->assertSame(EtatDemande::Approuvee, $demande->fresh()->etat);
    }

    public function test_approbation_refusee_sans_transmission_par_http(): void
    {
        $demande = $this->creerDemande(['etat' => EtatDemande::EnAttente, 'budget' => '800000']);

        $this->actingAs(User::factory()->create(['role' => 'verificateur']))
            ->post(route('demande.prixbudget', $demande->id), ['budget_accorde' => 600000, 'date_approbation' => '2026-10-01'])
            ->assertRedirect();

        $this->assertSame(EtatDemande::EnAttente, $demande->fresh()->etat);
    }

    public function test_transmission_depuis_la_liste_livewire(): void
    {
        $demande = $this->creerDemande(['etat' => EtatDemande::EnAttente]);
        $this->actingAs(User::factory()->create(['role' => 'secretaire']));

        Livewire::test(ListeDemande::class)->call('Transmetre', $demande->id);

        $this->assertSame(EtatDemande::Transmise, $demande->fresh()->etat);
    }

    public function test_retransmission_depuis_les_suspendues_livewire(): void
    {
        $demande = $this->creerDemande(['etat' => EtatDemande::Suspendue]);
        $this->actingAs(User::factory()->create(['role' => 'verificateur']));

        Livewire::test(DemandeSuspendu::class)->call('Transmetre', $demande->id);

        $this->assertSame(EtatDemande::Transmise, $demande->fresh()->etat);
    }

    /**
     * @dataProvider boutonsDeLaFiche
     */
    public function test_fiche_ne_propose_que_les_actions_permises(string $role, string $etat, bool $cloturee, array $visibles, array $absents): void
    {
        $demande = $this->creerDemande(['etat' => EtatDemande::from($etat), 'cloturee_le' => $cloturee ? now() : null]);

        $page = $this->actingAs(User::factory()->create(['role' => $role]))->get(route('demande.show', $demande->id))->assertOk();

        foreach ($visibles as $titre) {
            $page->assertSee("title=\"{$titre}\"", false);
        }
        foreach ($absents as $titre) {
            $page->assertDontSee("title=\"{$titre}\"", false);
        }
    }

    public static function boutonsDeLaFiche(): array
    {
        return [
            'vérificateur, transmise' => ['verificateur', 'transmise', false, ['Valider', 'Rejeter'], []],
            'vérificateur, en attente' => ['verificateur', 'en_attente', false, [], ['Valider', 'Rejeter']],
            'vérificateur, suspendue' => ['verificateur', 'suspendue', false, [], ['Valider', 'Rejeter']],
            'vérificateur, transmise clôturée' => ['verificateur', 'transmise', true, [], ['Valider', 'Rejeter', 'Supprimer']],
            'secrétaire, en attente' => ['secretaire', 'en_attente', false, ['Transmettre', 'Modifier', 'Supprimer'], []],
            'secrétaire, suspendue' => ['secretaire', 'suspendue', false, ['Transmettre'], []],
            'secrétaire, transmise' => ['secretaire', 'transmise', false, [], ['Transmettre']],
            'secrétaire, en attente clôturée' => ['secretaire', 'en_attente', true, [], ['Transmettre', 'Modifier', 'Supprimer']],
        ];
    }
}
