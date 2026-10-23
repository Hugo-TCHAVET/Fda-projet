<?php

namespace Tests\Feature;

use App\Enums\EtatDemande;
use App\Exports\DemandesApprouveesExport;
use App\Exports\DemandesRejeteesExport;
use App\Http\Livewire\DemandeApprouve;
use App\Http\Livewire\DemandeVerifier;
use App\Http\Livewire\IndexAdmin;
use App\Http\Livewire\PostAppui;
use App\Models\Demande;
use App\Models\User;
use App\Services\StatistiquesBeneficiaires;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Exceptions\MethodNotFoundException;
use Livewire\Livewire;
use Tests\Concerns\CreeDonneesReference;
use Tests\TestCase;

/**
 * Gate: a demande of a closed fiscal year is invisible in every live screen and cannot be changed.
 */
class FenetreClotureTest extends TestCase
{
    use RefreshDatabase;
    use CreeDonneesReference;

    private const DRAPEAUX = [
        'en_attente' => [],
        'transmise' => [],
        'suspendue' => [],
        'approuvee' => ['budget_accorde' => '100000', 'rapport_depose' => true, 'effectif_homme_forme' => 5, 'effectif_femme_forme' => 5],
    ];

    /** @var array<string, Demande> */
    private array $cloturees = [];

    protected function setUp(): void
    {
        parent::setUp();
        $this->creerDonneesReference();

        foreach (self::DRAPEAUX as $etat => $drapeaux) {
            $this->creerDemande(['structure' => "Vivante {$etat}", 'etat' => EtatDemande::from($etat)] + $drapeaux);
            $this->cloturees[$etat] = $this->creerDemande([
                'structure' => "Ancienne {$etat}",
                'etat' => EtatDemande::from($etat),
                'cloturee_le' => now(),
            ] + $drapeaux);
        }
    }

    private function en(string $role): self
    {
        return $this->actingAs(User::factory()->create(['role' => $role]));
    }

    public function test_listes_sans_dossier_cloture(): void
    {
        $pages = [
            ['secretaire', 'liste.demande', 'en_attente'],
            ['verificateur', 'demande.verifier', 'transmise'],
            ['verificateur', 'demande.suspendu', 'suspendue'],
            ['verificateur', 'demande.approve', 'approuvee'],
            ['verificateur', 'post-appui', 'approuvee'],
        ];

        foreach ($pages as [$role, $page, $etat]) {
            $this->en($role)->get(route($page))
                ->assertOk()
                ->assertSee("Vivante {$etat}")
                ->assertDontSee('Ancienne');
        }

        $this->en('directeur')->get(route('suivi.demandes'))->assertOk()->assertDontSee('Ancienne');
    }

    public function test_tableau_de_bord_sans_dossier_cloture(): void
    {
        $this->en('directeur');

        Livewire::test(IndexAdmin::class)
            ->assertViewHas('totaldemandes', 3)
            ->assertViewHas('demandesapprouvees', 1);
    }

    public function test_statistiques_et_exports_sans_dossier_cloture(): void
    {
        $this->assertSame(['allocations' => 1, 'rapports' => 1], StatistiquesBeneficiaires::pourDemandes()->couverture());
        $this->assertCount(1, (new DemandesApprouveesExport())->collection());
        $this->assertCount(1, (new DemandesRejeteesExport())->collection());
    }

    public function test_dossier_cloture_non_modifiable(): void
    {
        $this->en('secretaire')->post(route('demande.transmettre', $this->cloturees['en_attente']->id));
        $this->en('verificateur')->post(route('demande.suspendre', $this->cloturees['transmise']->id), ['message' => 'x']);
        $this->en('verificateur')->post(route('demande.prixbudget', $this->cloturees['transmise']->id), ['budget_accorde' => 1, 'date_approbation' => '2026-10-01']);
        $this->en('secretaire')->put(route('update.demande', $this->cloturees['en_attente']->id), AccesDemandesTest::chargeUtileDemande());
        $this->en('secretaire')->delete(route('demande.delete', $this->cloturees['en_attente']->id));

        $this->en('verificateur');
        Livewire::test(PostAppui::class)
            ->set('demandeId', $this->cloturees['approuvee']->id)
            ->set('date_depot_rapport', '2026-10-01')
            ->set('effectif_homme_forme', 99)
            ->set('effectif_femme_forme', 99)
            ->set('effectif_handicape_homme', 0)
            ->set('effectif_handicape_femme', 0)
            ->call('store');
        Livewire::test(DemandeApprouve::class)
            ->set('demandeIdArchive', $this->cloturees['approuvee']->id)
            ->set('annee_exercice', 2025)
            ->call('archiver');

        $this->assertSame(EtatDemande::EnAttente, $this->cloturees['en_attente']->fresh()->etat);
        $this->assertSame('Ancienne en_attente', $this->cloturees['en_attente']->fresh()->structure);
        $this->assertSame(EtatDemande::Transmise, $this->cloturees['transmise']->fresh()->etat);
        $this->assertSame(5, (int) $this->cloturees['approuvee']->fresh()->effectif_homme_forme);
        $this->assertFalse((bool) $this->cloturees['approuvee']->fresh()->archivee);
    }

    public function test_aucune_action_livewire_ne_supprime_un_dossier_cloture(): void
    {
        $this->en('verificateur');

        try {
            Livewire::test(DemandeVerifier::class)->call('RejeterDemande', $this->cloturees['transmise']->id);
        } catch (MethodNotFoundException) {
        }

        $this->assertModelExists($this->cloturees['transmise']);
    }
}
