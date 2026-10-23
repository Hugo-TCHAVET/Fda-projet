<?php

namespace Tests\Feature;

use App\Http\Livewire\PostAppui;
use App\Models\Demande;
use App\Enums\EtatDemande;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;
use Tests\Concerns\CreeDonneesReference;
use Tests\TestCase;

class PostAppuiRapportTest extends TestCase
{
    use RefreshDatabase;
    use CreeDonneesReference;

    private Demande $demande;

    protected function setUp(): void
    {
        parent::setUp();
        Storage::fake('local');
        $this->creerDonneesReference();
        $this->demande = $this->creerDemande(['etat' => EtatDemande::Approuvee, 'budget_accorde' => '500000']);
        $this->actingAs(User::factory()->create(['role' => 'verificateur']));
    }

    private function formulaire(array $valeurs)
    {
        $composant = Livewire::test(PostAppui::class)->call('edit', $this->demande->id);
        foreach ($valeurs as $champ => $valeur) {
            $composant->set($champ, $valeur);
        }

        return $composant->call('store');
    }

    private function valeursValides(): array
    {
        return [
            'date_depot_rapport' => '2026-10-15',
            'effectif_homme_forme' => 10,
            'effectif_femme_forme' => 30,
            'effectif_handicape_homme' => 1,
            'effectif_handicape_femme' => 3,
            'observations_rapport' => 'Formation achevée',
        ];
    }

    public function test_rapport_complet_enregistre(): void
    {
        $this->formulaire($this->valeursValides() + [
            'rapport_fichier' => UploadedFile::fake()->create('rapport.pdf', 100, 'application/pdf'),
        ])->assertHasNoErrors();

        $demande = $this->demande->fresh();
        $this->assertTrue((bool) $demande->rapport_depose);
        $this->assertSame(10, (int) $demande->effectif_homme_forme);
        $this->assertSame(30, (int) $demande->effectif_femme_forme);
        $this->assertSame(1, (int) $demande->effectif_handicape_homme);
        $this->assertSame(3, (int) $demande->effectif_handicape_femme);
        $this->assertSame('Formation achevée', $demande->observations_rapport);
        $this->assertStringStartsWith('rapports/', $demande->rapport_fichier);
        Storage::disk('local')->assertExists($demande->rapport_fichier);
    }

    public function test_handicapes_superieurs_aux_formes_refuse(): void
    {
        $this->formulaire(array_merge($this->valeursValides(), ['effectif_homme_forme' => 2, 'effectif_handicape_homme' => 3]))
            ->assertHasErrors(['effectif_handicape_homme' => 'lte']);

        $this->assertFalse((bool) $this->demande->fresh()->rapport_depose);
    }

    public function test_handicap_obligatoire(): void
    {
        $this->formulaire(array_merge($this->valeursValides(), ['effectif_handicape_femme' => '']))
            ->assertHasErrors(['effectif_handicape_femme' => 'required']);
    }

    public function test_fichier_non_pdf_refuse(): void
    {
        $this->formulaire($this->valeursValides() + [
            'rapport_fichier' => UploadedFile::fake()->create('rapport.docx', 100, 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'),
        ])->assertHasErrors(['rapport_fichier' => 'mimes']);
    }

    public function test_edition_conserve_fichier_si_aucun_nouveau(): void
    {
        Storage::disk('local')->put('rapports/existant.pdf', '%PDF-1.4');
        $this->demande->update(['rapport_depose' => true, 'rapport_fichier' => 'rapports/existant.pdf']);

        $this->formulaire($this->valeursValides())->assertHasNoErrors();

        $this->assertSame('rapports/existant.pdf', $this->demande->fresh()->rapport_fichier);
    }

    public function test_nouveau_fichier_remplace_l_ancien(): void
    {
        Storage::disk('local')->put('rapports/ancien.pdf', '%PDF-1.4');
        $this->demande->update(['rapport_depose' => true, 'rapport_fichier' => 'rapports/ancien.pdf']);

        $this->formulaire($this->valeursValides() + [
            'rapport_fichier' => UploadedFile::fake()->create('nouveau.pdf', 100, 'application/pdf'),
        ])->assertHasNoErrors();

        $chemin = $this->demande->fresh()->rapport_fichier;
        $this->assertNotSame('rapports/ancien.pdf', $chemin);
        Storage::disk('local')->assertMissing('rapports/ancien.pdf');
        Storage::disk('local')->assertExists($chemin);
    }

    private function rendreAncienRapport(): void
    {
        $this->demande->update([
            'rapport_depose' => true,
            'effectif_homme_forme' => 100,
            'effectif_femme_forme' => 250,
            'effectif_handicape_homme' => null,
            'effectif_handicape_femme' => null,
        ]);
    }

    public function test_ancien_rapport_peut_rester_sans_handicap(): void
    {
        $this->rendreAncienRapport();

        Livewire::test(PostAppui::class)
            ->call('edit', $this->demande->id)
            ->set('rapport_fichier', UploadedFile::fake()->create('rapport.pdf', 100, 'application/pdf'))
            ->call('store')
            ->assertHasNoErrors();

        $demande = $this->demande->fresh();
        $this->assertNull($demande->effectif_handicape_homme);
        $this->assertNull($demande->effectif_handicape_femme);
        $this->assertStringStartsWith('rapports/', $demande->rapport_fichier);
    }

    public function test_ancien_rapport_handicap_partiel_refuse(): void
    {
        $this->rendreAncienRapport();

        Livewire::test(PostAppui::class)
            ->call('edit', $this->demande->id)
            ->set('effectif_handicape_homme', 1)
            ->call('store')
            ->assertHasErrors(['effectif_handicape_femme']);
    }

    public function test_remplacement_ne_supprime_pas_le_fichier_d_une_autre_demande(): void
    {
        Storage::disk('local')->put('rapports/autre.pdf', '%PDF-1.4');
        $this->creerDemande(['etat' => EtatDemande::Approuvee, 'rapport_depose' => true, 'rapport_fichier' => 'rapports/autre.pdf']);
        $this->demande->update(['rapport_depose' => true, 'rapport_fichier' => 'rapports/autre.pdf']);

        $this->formulaire($this->valeursValides() + [
            'rapport_fichier' => UploadedFile::fake()->create('nouveau.pdf', 100, 'application/pdf'),
        ])->assertHasNoErrors();

        Storage::disk('local')->assertExists('rapports/autre.pdf');
    }

    public function test_remplacement_ne_supprime_rien_hors_du_dossier_rapports(): void
    {
        Storage::disk('local')->put('secret.txt', 'secret');
        $this->demande->update(['rapport_depose' => true, 'rapport_fichier' => 'secret.txt']);

        $this->formulaire($this->valeursValides() + [
            'rapport_fichier' => UploadedFile::fake()->create('nouveau.pdf', 100, 'application/pdf'),
        ])->assertHasNoErrors();

        Storage::disk('local')->assertExists('secret.txt');
    }

    public function test_rapport_refuse_pour_demande_non_approuvee(): void
    {
        $nonApprouvee = $this->creerDemande(['etat' => EtatDemande::Transmise, 'budget_accorde' => null]);

        $composant = Livewire::test(PostAppui::class)->set('demandeId', $nonApprouvee->id);
        foreach ($this->valeursValides() as $champ => $valeur) {
            $composant->set($champ, $valeur);
        }
        $composant->call('store');

        $this->assertFalse((bool) $nonApprouvee->fresh()->rapport_depose);
    }

    public function test_identifiant_non_numerique_refuse_sans_erreur(): void
    {
        $composant = Livewire::test(PostAppui::class)->set('demandeId', 'abc');
        foreach ($this->valeursValides() as $champ => $valeur) {
            $composant->set($champ, $valeur);
        }

        $composant->call('store')->assertSet('showModal', false);
        $this->assertSame(0, Demande::where('rapport_depose', true)->count());
    }

    public function test_edition_refusee_pour_demande_non_approuvee(): void
    {
        $nonApprouvee = $this->creerDemande(['etat' => EtatDemande::Transmise, 'budget_accorde' => null]);

        Livewire::test(PostAppui::class)
            ->call('edit', $nonApprouvee->id)
            ->assertSet('showModal', false);
    }

    public function test_nouveau_fichier_supprime_si_enregistrement_echoue(): void
    {
        Demande::updating(function () {
            throw new \RuntimeException('panne');
        });

        $this->formulaire($this->valeursValides() + [
            'rapport_fichier' => UploadedFile::fake()->create('rapport.pdf', 100, 'application/pdf'),
        ]);

        $this->assertSame([], Storage::disk('local')->files('rapports'));
    }

    public function test_fichier_conserve_si_erreur_apres_enregistrement(): void
    {
        Demande::updated(function () {
            throw new \RuntimeException('panne après écriture');
        });

        $this->formulaire($this->valeursValides() + [
            'rapport_fichier' => UploadedFile::fake()->create('rapport.pdf', 100, 'application/pdf'),
        ]);

        $chemin = $this->demande->fresh()->rapport_fichier;
        $this->assertNotNull($chemin);
        Storage::disk('local')->assertExists($chemin);
    }
}
