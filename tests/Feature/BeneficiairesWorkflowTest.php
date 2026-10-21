<?php

namespace Tests\Feature;

use App\Http\Livewire\PostAppui;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;
use Tests\Concerns\CreeDonneesReference;
use Tests\TestCase;

/**
 * Parcours réel d'une allocation : transmission, approbation, rapport post-appui, statistiques, fiche PDF.
 * Écrit storage/app/e2e/beneficiaires-workflow.json.
 */
class BeneficiairesWorkflowTest extends TestCase
{
    use RefreshDatabase;
    use CreeDonneesReference;

    public function test_parcours_complet_d_une_allocation(): void
    {
        Storage::fake('local');
        $this->creerDonneesReference();
        $secretaire = User::factory()->create(['role' => 'secretaire']);
        $verificateur = User::factory()->create(['role' => 'verificateur']);
        $directeur = User::factory()->create(['role' => 'directeur']);
        $demande = $this->creerDemande(['budget' => '800000', 'branche' => '1', 'service' => 'Formation']);
        $etapes = [];

        $etapes['transmission'] = $this->actingAs($secretaire)->get(route('demande.transmettre', $demande->id))->getStatusCode();
        $this->assertSame('1', (string) $demande->fresh()->valide);

        $etapes['approbation'] = $this->actingAs($verificateur)
            ->post(route('demande.prixbudget', $demande->id), ['buget_prevu' => 600000, 'date_approbation' => '2026-10-01'])
            ->getStatusCode();
        $this->assertSame('2', (string) $demande->fresh()->valide);

        $this->actingAs($verificateur);
        Livewire::test(PostAppui::class)
            ->call('edit', $demande->id)
            ->set('date_depot_rapport', '2026-10-20')
            ->set('effectif_homme_forme', 12)
            ->set('effectif_femme_forme', 18)
            ->set('effectif_handicape_homme', 2)
            ->set('effectif_handicape_femme', 1)
            ->set('observations_rapport', 'Formation achevée')
            ->set('rapport_fichier', UploadedFile::fake()->create('rapport.pdf', 50, 'application/pdf'))
            ->call('store')
            ->assertHasNoErrors();
        $etapes['rapport_fichier'] = $demande->fresh()->rapport_fichier;

        $page = $this->actingAs($directeur)->get(route('statistiques.admin'));
        $page->assertOk()
            ->assertSee('40,0 %')
            ->assertSee('60,0 %')
            ->assertSee('10,0 %')
            ->assertSee('90,0 %')
            ->assertSee('calculé sur 1 rapports / 1 allocations');
        $etapes['statistiques'] = $page->getStatusCode();

        $fiche = $this->get(route('rapport.fiche', $demande->id));
        $fiche->assertOk()->assertHeader('Content-Type', 'application/pdf');
        $etapes['fiche_pdf'] = ['status' => $fiche->getStatusCode(), 'octets' => strlen($fiche->getContent())];

        $etapes['fichier_rapport'] = $this->actingAs($verificateur)->get(route('rapport.fichier', $demande->id))->getStatusCode();

        $chemin = storage_path('app/e2e/beneficiaires-workflow.json');
        @mkdir(dirname($chemin), 0775, true);
        file_put_contents($chemin, json_encode([
            'genere_le' => now()->toIso8601String(),
            'etapes' => $etapes,
            'attendu' => ['taux_hommes' => '40,0 %', 'taux_femmes' => '60,0 %', 'taux_handicapes' => '10,0 %'],
        ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));
    }
}
