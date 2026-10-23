<?php

namespace Tests\Feature;

use App\Models\Demande;
use App\Enums\EtatDemande;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Concerns\CreeDonneesReference;
use Tests\TestCase;

class AccesDemandesTest extends TestCase
{
    use RefreshDatabase;
    use CreeDonneesReference;

    private Demande $demande;

    protected function setUp(): void
    {
        parent::setUp();
        $this->creerDonneesReference();
        $this->demande = $this->creerDemande(['structure' => 'Structure d origine']);
    }

    private function connecte(string $role): self
    {
        return $this->actingAs(User::factory()->create(['role' => $role]));
    }

    public function test_modification_publique_impossible(): void
    {
        $this->get('/demande/modifier/'.$this->demande->id)->assertNotFound();

        $reponse = $this->put('/demande/update/'.$this->demande->id, ['structure' => 'Piratée']);
        $this->assertContains($reponse->getStatusCode(), [404, 405]);
        $this->assertSame('Structure d origine', $this->demande->fresh()->structure);
    }

    public static function chargeUtileDemande(): array
    {
        return [
            'structure' => 'Atelier Test',
            'service' => 'Formation',
            'type_demande' => 'structure',
            'nom' => 'Doe',
            'prenom' => 'Jane',
            'sexe' => 'Féminin',
            'ifu' => '1234567890123',
            'titre_activite' => 'Titre',
            'objectif_activite' => 'Objectif',
            'budget' => 500000,
        ];
    }

    public function test_creation_refusee_sans_connexion(): void
    {
        $this->post(route('demande.store'), self::chargeUtileDemande())->assertRedirect('/login');

        $this->assertDatabaseMissing('demandes', ['structure' => 'Atelier Test']);
    }

    public function test_creation_refusee_au_verificateur(): void
    {
        $this->connecte('verificateur')->post(route('demande.store'), self::chargeUtileDemande())->assertForbidden();

        $this->assertDatabaseMissing('demandes', ['structure' => 'Atelier Test']);
    }

    public function test_secretaire_cree_une_demande(): void
    {
        $this->connecte('secretaire')->post(route('demande.store'), self::chargeUtileDemande());

        $this->assertDatabaseHas('demandes', ['structure' => 'Atelier Test', 'etat' => 'en_attente']);
    }

    public function test_suppression_par_lien_impossible(): void
    {
        $this->connecte('secretaire')->get('/delete/'.$this->demande->id)->assertNotFound();

        $this->assertNotNull($this->demande->fresh());
    }

    public function test_suppression_par_formulaire(): void
    {
        $this->connecte('secretaire')->delete(route('demande.delete', $this->demande->id))->assertRedirect();

        $this->assertNull($this->demande->fresh());
    }

    public function test_suppression_refusee_au_directeur(): void
    {
        $this->connecte('directeur')->delete(route('demande.delete', $this->demande->id))->assertForbidden();

        $this->assertNotNull($this->demande->fresh());
    }

    public function test_boutons_supprimer_envoient_un_formulaire(): void
    {
        $this->connecte('secretaire');

        foreach ([route('liste.demande'), route('demande.show', $this->demande->id)] as $page) {
            $this->get($page)
                ->assertDontSee("/delete/", false)
                ->assertSee('name="_method" value="DELETE"', false);
        }
    }

    public function test_transmission_par_lien_impossible(): void
    {
        $this->connecte('secretaire')->get('/transmettre_demande/'.$this->demande->id);

        $this->assertSame(EtatDemande::EnAttente, $this->demande->fresh()->etat);
    }

    public function test_transmission_par_formulaire(): void
    {
        $this->connecte('secretaire')->post(route('demande.transmettre', $this->demande->id))->assertRedirect();

        $this->assertSame(EtatDemande::Transmise, $this->demande->fresh()->etat);
    }

    public function test_bouton_transmettre_envoie_un_formulaire(): void
    {
        $this->connecte('secretaire')->get(route('demande.show', $this->demande->id))
            ->assertDontSee('/transmettre_demande', false)
            ->assertSee('form.action = "'.url('/demandes').'/" + demandeId + "/transmission"', false);
    }

    public function test_inscription_publique_fermee(): void
    {
        $this->get('/register')->assertNotFound();

        $this->post('/register', [
            'name' => 'Visiteur',
            'email' => 'visiteur@example.invalid',
            'password' => 'MotDePasse!2026x',
            'password_confirmation' => 'MotDePasse!2026x',
        ]);
        $this->assertDatabaseMissing('users', ['email' => 'visiteur@example.invalid']);
    }

    public function test_tableau_de_bord_refuse_au_role_client(): void
    {
        $this->connecte('client')->get(route('home'))->assertForbidden();
    }

    public function test_page_403_propose_la_deconnexion(): void
    {
        $this->connecte('client')->get(route('home'))
            ->assertForbidden()
            ->assertSee('action="'.route('logout').'"', false);
    }

    public function test_tableau_de_bord_ouvert_au_personnel(): void
    {
        foreach (['secretaire', 'verificateur', 'directeur'] as $role) {
            $this->connecte($role)->get(route('home'))->assertOk();
        }
    }

    public function test_pages_secretaire_s_affichent(): void
    {
        $this->connecte('secretaire');

        $this->get(route('liste.demande'))->assertOk();
        $this->get(route('demande.show', $this->demande->id))->assertOk();
        $this->get(route('demande.edit', $this->demande->id))->assertOk();
    }
}
