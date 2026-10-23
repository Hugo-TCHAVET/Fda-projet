<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Tests\Concerns\CreeDonneesReference;
use Tests\TestCase;

class PieceJointeTest extends TestCase
{
    use RefreshDatabase;
    use CreeDonneesReference;

    protected function setUp(): void
    {
        parent::setUp();
        Storage::fake('uploads');
        $this->creerDonneesReference();
        $this->actingAs(User::factory()->create(['role' => 'secretaire']));
    }

    public function test_piece_telechargee(): void
    {
        Storage::disk('uploads')->put('piece/dossier.pdf', '%PDF-1.4 pièce');
        $demande = $this->creerDemande(['piece' => 'piece/dossier.pdf']);

        $reponse = $this->get(route('demande.piece', $demande->id));

        $reponse->assertOk();
        $this->assertSame('%PDF-1.4 pièce', $reponse->streamedContent());
    }

    public function test_piece_d_un_dossier_cloture_telechargee(): void
    {
        Storage::disk('uploads')->put('piece/ancien.pdf', '%PDF-1.4 ancien');
        $cloturee = $this->creerDemande(['piece' => 'piece/ancien.pdf', 'exercice' => 2025, 'cloturee_le' => now()]);
        $this->actingAs(User::factory()->create(['role' => 'directeur']));

        $reponse = $this->get(route('demande.cloture.piece', $cloturee->id));

        $reponse->assertOk();
        $this->assertSame('%PDF-1.4 ancien', $reponse->streamedContent());
    }

    public function test_pdf_d_une_structure_au_nom_avec_barre_oblique(): void
    {
        $demande = $this->creerDemande(['structure' => 'GIE A/B « Été »']);

        $reponse = $this->get(route('demande.pdf', $demande->id));

        $reponse->assertOk();
        $this->assertStringContainsString('attachment', $reponse->headers->get('Content-Disposition'));
    }

    public function test_demande_sans_piece_ne_plante_pas(): void
    {
        $demande = $this->creerDemande(['piece' => null]);

        $this->get(route('demande.piece', $demande->id))->assertRedirect();
    }

    public function test_piece_introuvable_ne_plante_pas(): void
    {
        $demande = $this->creerDemande(['piece' => 'piece/absente.pdf']);

        $this->get(route('demande.piece', $demande->id))->assertRedirect();
    }
}
