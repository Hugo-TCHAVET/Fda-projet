<?php

namespace Tests\Feature;

use App\Enums\EtatDemande;
use App\Exports\DemandesApprouveesExport;
use App\Exports\DemandesClotureesExport;
use App\Exports\DemandesRejeteesExport;
use App\Http\Livewire\DemandeApprouve;
use App\Http\Livewire\DemandeSuspendu;
use App\Http\Livewire\DemandeVerifier;
use App\Http\Livewire\ListeDemande;
use App\Http\Livewire\SuiviDemandes;
use App\Models\Demande;
use App\Models\User;
use App\Support\Orphelins;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use Livewire\Livewire;
use Tests\Concerns\CreeDonneesReference;
use Tests\TestCase;

/**
 * Every screen that shows a demande's branche, corps and metier resolves the names, not the ids.
 */
class ReferencesDemandeTest extends TestCase
{
    use RefreshDatabase;
    use CreeDonneesReference;

    private const NOMS = ['Bois', 'Corps témoin', 'Métier témoin'];

    protected function setUp(): void
    {
        parent::setUp();
        $this->creerDonneesReference();
        DB::table('corps')->insert(['id' => 7, 'nom' => 'Corps témoin', 'branche_id' => 1]);
        DB::table('metiers')->insert(['id' => 9, 'nom' => 'Métier témoin', 'branche_id' => 1, 'corp_id' => 7]);
    }

    private function demande(EtatDemande $etat, bool $cloturee = false): Demande
    {
        return $this->creerDemande([
            'etat' => $etat,
            'branche_id' => 1,
            'corps_id' => 7,
            'metier_id' => 9,
            'budget_accorde' => 100000,
            'cloturee_le' => $cloturee ? now() : null,
        ]);
    }

    private function en(string $role): self
    {
        return $this->actingAs(User::factory()->create(['role' => $role]));
    }

    public function test_fiches_affichent_les_noms(): void
    {
        $vivante = $this->demande(EtatDemande::Transmise);
        $cloturee = $this->demande(EtatDemande::Approuvee, true);

        $this->en('verificateur')->get(route('demande.show', $vivante->id))->assertOk()->assertSee(self::NOMS);
        $this->en('directeur')->get(route('demande.cloture.show', $cloturee->id))->assertOk()->assertSee(self::NOMS);
    }

    public function test_pdf_recoivent_les_noms(): void
    {
        $vivante = $this->demande(EtatDemande::Transmise);
        $cloturee = $this->demande(EtatDemande::Approuvee, true);
        $recus = [];
        View::composer(['Admin.pdf', 'Admin.pdf-cloture'], function ($vue) use (&$recus) {
            $recus[$vue->name()] = [$vue->branche?->nom, $vue->corps?->nom, $vue->metier?->nom];
        });

        $this->en('verificateur')->get(route('demande.pdf', $vivante->id))->assertOk();
        $this->en('directeur')->get(route('demande.cloture.pdf', $cloturee->id))->assertOk();

        $this->assertSame(['Admin.pdf' => self::NOMS, 'Admin.pdf-cloture' => self::NOMS], $recus);
    }

    public function test_exports_affichent_les_noms(): void
    {
        $exports = [
            [new DemandesApprouveesExport(), $this->demande(EtatDemande::Approuvee)],
            [new DemandesRejeteesExport(), $this->demande(EtatDemande::Suspendue)],
            [new DemandesClotureesExport(2026), $this->demande(EtatDemande::Approuvee, true)],
        ];

        foreach ($exports as [$export, $demande]) {
            $ligne = $export->map($demande);
            foreach (self::NOMS as $nom) {
                $this->assertContains($nom, $ligne, get_class($export));
            }
        }
    }

    public function test_modales_livewire_affichent_les_noms(): void
    {
        $composants = [
            [ListeDemande::class, 'update', EtatDemande::EnAttente, 'secretaire'],
            [DemandeVerifier::class, 'update', EtatDemande::Transmise, 'verificateur'],
            [DemandeSuspendu::class, 'update', EtatDemande::Suspendue, 'verificateur'],
            [DemandeApprouve::class, 'update', EtatDemande::Approuvee, 'verificateur'],
            [SuiviDemandes::class, 'update', EtatDemande::Transmise, 'directeur'],
        ];

        foreach ($composants as [$composant, $methode, $etat, $role]) {
            $this->en($role);
            Livewire::test($composant)
                ->call($methode, $this->demande($etat)->id)
                ->assertSet('branche', 'Bois')
                ->assertSet('corps', 'Corps témoin')
                ->assertSet('metier', 'Métier témoin');
        }
    }

    public function test_relations_demande(): void
    {
        $demande = $this->demande(EtatDemande::EnAttente)->fresh();

        $this->assertSame(self::NOMS, [$demande->branche->nom, $demande->corps->nom, $demande->metier->nom]);
    }

    public function test_suppression_branche_met_null(): void
    {
        $demande = $this->creerDemande(['branche_id' => 2, 'corps_id' => null, 'metier_id' => null]);

        DB::table('branches')->where('id', 2)->delete();

        $this->assertNull($demande->fresh()->branche_id);
    }

    public function test_cle_etrangere_refuse_une_branche_inexistante(): void
    {
        $this->expectException(QueryException::class);

        $this->creerDemande(['branche_id' => 999, 'corps_id' => null, 'metier_id' => null]);
    }

    public function test_creation_enregistre_les_references(): void
    {
        $this->en('secretaire')->post(route('demande.store'), ['branche_id' => 1, 'corps_id' => 7, 'metier_id' => 9] + AccesDemandesTest::chargeUtileDemande());

        $this->assertDatabaseHas('demandes', ['structure' => 'Atelier Test', 'branche_id' => 1, 'corps_id' => 7, 'metier_id' => 9]);
    }

    public function test_creation_sans_reference_enregistre_null(): void
    {
        $this->en('secretaire')->post(route('demande.store'), AccesDemandesTest::chargeUtileDemande());

        $this->assertDatabaseHas('demandes', ['structure' => 'Atelier Test', 'branche_id' => null, 'corps_id' => null, 'metier_id' => null]);
    }

    public function test_modification_enregistre_les_references(): void
    {
        $demande = $this->demande(EtatDemande::EnAttente);

        $this->en('secretaire')->put(route('update.demande', $demande->id), ['branche_id' => 2, 'corps_id' => '', 'metier_id' => ''] + AccesDemandesTest::chargeUtileDemande());

        $this->assertDatabaseHas('demandes', ['id' => $demande->id, 'branche_id' => 2, 'corps_id' => null, 'metier_id' => null]);
    }

    public function test_orphelins_mis_a_null_et_traces(): void
    {
        DB::statement('CREATE TEMPORARY TABLE demandes_texte (id INT, branche VARCHAR(255))');
        DB::table('demandes_texte')->insert([
            ['id' => 1, 'branche' => '1'],
            ['id' => 2, 'branche' => '999'],
            ['id' => 3, 'branche' => ''],
            ['id' => 4, 'branche' => null],
            ['id' => 5, 'branche' => '2abc'],
            ['id' => 6, 'branche' => ' 2 '],
        ]);

        $orphelins = Orphelins::neutraliser('demandes_texte', 'branche', 'branches');

        $this->assertSame([[2, 'branche', '999'], [5, 'branche', '2abc']], $orphelins);
        $this->assertSame(['1', null, null, null, null, '2'], DB::table('demandes_texte')->orderBy('id')->pluck('branche')->all());
    }

    /**
     * @dataProvider referencesNonEntieres
     */
    public function test_reference_non_entiere_refusee_par_la_validation(string $champ, array $saisie): void
    {
        $demande = $this->demande(EtatDemande::EnAttente);

        $this->en('secretaire')
            ->put(route('update.demande', $demande->id), $saisie + AccesDemandesTest::chargeUtileDemande())
            ->assertSessionHasErrors($champ);

        $this->en('secretaire')
            ->post(route('demande.store'), $saisie + AccesDemandesTest::chargeUtileDemande())
            ->assertSessionHasErrors($champ);
    }

    // '2abc' passes a bare `exists` rule (MySQL casts it to 2) and then breaks the integer column.
    public static function referencesNonEntieres(): array
    {
        $lieu = ['departement_id' => 1, 'commune_id' => 1, 'lieux' => 'Cotonou', 'homme_touche' => 5];

        return [
            'branche' => ['branche_id', ['branche_id' => '2abc']],
            'corps' => ['corps_id', ['corps_id' => '7abc']],
            'métier' => ['metier_id', ['metier_id' => '9abc']],
            'département du lieu' => ['localisations.0.departement_id', ['localisations' => [['departement_id' => '1abc'] + $lieu]]],
            'commune du lieu' => ['localisations.0.commune_id', ['localisations' => [['commune_id' => '1abc'] + $lieu]]],
        ];
    }

    public function test_formulaire_restaure_les_references_apres_erreur(): void
    {
        $this->en('secretaire')
            ->withSession(['_old_input' => ['branche_id' => '1', 'corps_id' => '7', 'metier_id' => '9']])
            ->get(route('client.formulaire'))
            ->assertOk()
            ->assertSee('<option value="1" selected>Bois</option>', false)
            ->assertSee("if ('1') {", false)
            ->assertSee("document.getElementById('corps').value = '7';", false)
            ->assertSee("document.getElementById('metier').value = '9';", false);
    }

    public function test_edition_preselectionne_les_references(): void
    {
        $demande = $this->demande(EtatDemande::EnAttente);

        $this->en('secretaire')->get(route('demande.edit', $demande->id))
            ->assertOk()
            ->assertSee('<option value="1" selected>Bois</option>', false)
            ->assertSee('<option value="7" selected>Corps témoin</option>', false)
            ->assertSee('<option value="9" selected>Métier témoin</option>', false);
    }
}
