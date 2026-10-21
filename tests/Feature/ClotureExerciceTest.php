<?php

namespace Tests\Feature;

use App\Http\Livewire\DemandeApprouve;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Livewire\Livewire;
use Tests\Concerns\CreeDonneesReference;
use Tests\TestCase;

class ClotureExerciceTest extends TestCase
{
    use RefreshDatabase;
    use CreeDonneesReference;

    public function test_cloture_conserve_champs_rapport(): void
    {
        $this->creerDonneesReference();

        $demande = $this->creerDemande([
            'created_at' => '2024-05-10 10:00:00',
            'valide' => '2',
            'statuts' => 'Approuvé',
            'buget_prevu' => '500000',
            'rapport_depose' => true,
            'effectif_homme_forme' => 10,
            'effectif_femme_forme' => 30,
            'effectif_handicape_homme' => 1,
            'effectif_handicape_femme' => 3,
            'observations_rapport' => 'RAS',
            'rapport_fichier' => 'rapports/x.pdf',
        ]);

        $this->actingAs(User::factory()->create(['role' => 'verificateur']));

        Livewire::test(DemandeApprouve::class)
            ->set('annee_cloture', 2024)
            ->call('cloturerExercice');

        $this->assertDatabaseMissing('demandes', ['id' => $demande->id]);
        $cloture = DB::table('demandes_clotures')->where('demande_id_original', $demande->id)->first();
        $this->assertNotNull($cloture);
        $this->assertSame(1, (int) $cloture->effectif_handicape_homme);
        $this->assertSame(3, (int) $cloture->effectif_handicape_femme);
        $this->assertSame('RAS', $cloture->observations_rapport);
        $this->assertSame('rapports/x.pdf', $cloture->rapport_fichier);
        $this->assertSame(2024, (int) $cloture->annee_exercice_cloture);
    }
}
