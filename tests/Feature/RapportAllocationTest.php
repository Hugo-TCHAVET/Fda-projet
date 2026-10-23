<?php

namespace Tests\Feature;

use App\Models\Demande;
use App\Enums\EtatDemande;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\View;
use Tests\Concerns\CreeDonneesReference;
use Tests\TestCase;

class RapportAllocationTest extends TestCase
{
    use RefreshDatabase;
    use CreeDonneesReference;

    private Demande $demande;

    protected function setUp(): void
    {
        parent::setUp();
        Storage::fake('local');
        Storage::disk('local')->put('rapports/rapport.pdf', '%PDF-1.4 contenu');
        $this->creerDonneesReference();
        $this->demande = $this->creerDemande([
            'etat' => EtatDemande::Approuvee,
            'budget_accorde' => '500000',
            'rapport_depose' => true,
            'effectif_homme_forme' => 10,
            'effectif_femme_forme' => 30,
            'effectif_handicape_homme' => 1,
            'effectif_handicape_femme' => 3,
            'observations_rapport' => 'RAS',
            'rapport_fichier' => 'rapports/rapport.pdf',
        ]);
    }

    private function connecte(string $role): self
    {
        return $this->actingAs(User::factory()->create(['role' => $role]));
    }

    public function test_fiche_pdf_generee(): void
    {
        $reponse = $this->connecte('directeur')->get(route('rapport.fiche', $this->demande->id));

        $reponse->assertOk();
        $reponse->assertHeader('Content-Type', 'application/pdf');
    }

    public function test_fiche_refusee_si_pas_de_rapport(): void
    {
        $this->demande->update(['rapport_depose' => false]);

        $this->connecte('directeur')->get(route('rapport.fiche', $this->demande->id))->assertNotFound();
    }

    public function test_fichier_rapport_telecharge(): void
    {
        $reponse = $this->connecte('verificateur')->get(route('rapport.fichier', $this->demande->id));

        $reponse->assertOk();
        $this->assertSame('%PDF-1.4 contenu', $reponse->streamedContent());
    }

    public function test_fichier_rapport_refuse_sans_gate(): void
    {
        $this->connecte('secretaire')->get(route('rapport.fichier', $this->demande->id))->assertForbidden();
    }

    public function test_fichier_rapport_refuse_sans_connexion(): void
    {
        $this->get(route('rapport.fichier', $this->demande->id))->assertRedirect('/login');
    }

    public function test_fichier_absent_donne_404(): void
    {
        $this->demande->update(['rapport_fichier' => null]);

        $this->connecte('verificateur')->get(route('rapport.fichier', $this->demande->id))->assertNotFound();
    }

    public function test_chemin_hors_dossier_rapports_refuse(): void
    {
        Storage::disk('local')->put('secret.txt', 'secret');
        $this->demande->update(['rapport_fichier' => 'secret.txt']);

        $this->connecte('verificateur')->get(route('rapport.fichier', $this->demande->id))->assertNotFound();
    }

    public function test_chemin_avec_remontee_refuse(): void
    {
        $this->demande->update(['rapport_fichier' => 'rapports/../secret.txt']);

        $this->connecte('verificateur')->get(route('rapport.fichier', $this->demande->id))->assertNotFound();
    }

    private function donneesFiche(): array
    {
        $donnees = [];
        View::composer('Admin.fiche-allocation', function ($vue) use (&$donnees) {
            $donnees = $vue->getData();
        });
        $this->connecte('directeur')->get(route('rapport.fiche', $this->demande->id))->assertOk();

        return $donnees;
    }

    public function test_fiche_libelle_service_financier(): void
    {
        $this->demande->update(['service' => 'Financier']);

        $this->assertSame('Appui Financier', $this->donneesFiche()['libelleService']);
    }

    public function test_fiche_branche_non_renseignee(): void
    {
        $this->demande->update(['branche_id' => null]);

        $this->assertSame('Non renseigné', $this->donneesFiche()['libelleBranche']);
    }
}
