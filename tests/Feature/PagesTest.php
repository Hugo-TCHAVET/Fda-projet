<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Concerns\CreeDonneesReference;
use Tests\TestCase;

/**
 * Safety net: every GET page answers 200 for the role allowed by its gate.
 */
class PagesTest extends TestCase
{
    use RefreshDatabase;
    use CreeDonneesReference;

    // /contact is excluded until its form is fixed or removed (open question Q5).
    public static function pages(): array
    {
        return [
            'accueil' => [null, '/', false],
            'service' => [null, '/service', false],
            'a propos' => [null, '/A_propos', false],
            'connexion' => [null, '/login', false],
            'mot de passe oublié' => [null, '/forgot-password', false],
            'tableau de bord' => ['secretaire', 'home', false],
            'liste des demandes' => ['secretaire', 'liste.demande', false],
            'formulaire' => ['secretaire', 'client.formulaire', false],
            'détail' => ['secretaire', 'demande.show', 'demande'],
            'édition' => ['secretaire', 'demande.edit', 'demande'],
            'pdf demande' => ['secretaire', 'demande.pdf', 'demande'],
            'profil' => ['secretaire', 'profile.show', false],
            'demandes vérifiées' => ['verificateur', 'demande.verifier', false],
            'demandes approuvées' => ['verificateur', 'demande.approve', false],
            'demandes suspendues' => ['verificateur', 'demande.suspendu', false],
            'budget' => ['verificateur', 'demande.budget', 'demande'],
            'suspension' => ['verificateur', 'demande.message', 'demande'],
            'post-appui' => ['verificateur', 'post-appui', false],
            'fiche fin d allocation' => ['verificateur', 'rapport.fiche', 'demande'],
            'suivi' => ['directeur', 'suivi.demandes', false],
            'statistiques' => ['directeur', 'statistiques.admin', false],
            'exercices clôturés' => ['directeur', 'exercices.clotures', false],
            'détail clôturé' => ['directeur', 'demande.cloture.show', 'cloture'],
            'pdf clôturé' => ['directeur', 'demande.cloture.pdf', 'cloture'],
        ];
    }

    /**
     * @dataProvider pages
     */
    public function test_toutes_les_pages_s_affichent(?string $role, string $page, string|false $parametre): void
    {
        $this->withoutVite();
        $this->creerDonneesReference();
        $allocation = $this->creerAllocation([
            'budget_accorde' => '500000',
            'effectif_homme_forme' => 10,
            'effectif_femme_forme' => 20,
            'effectif_handicape_homme' => 1,
            'effectif_handicape_femme' => 2,
        ]);
        $cloturee = $this->creerAllocation(['structure' => 'Structure clôturée', 'exercice' => 2025, 'cloturee_le' => now()]);

        if ($role) {
            $this->actingAs(User::factory()->create(['role' => $role]));
        }

        $url = match ($parametre) {
            false => str_starts_with($page, '/') ? $page : route($page),
            'demande' => route($page, $allocation->id),
            'cloture' => route($page, $cloturee->id),
        };

        $reponse = $this->get($url);

        $reponse->assertOk();
        if (str_contains($page, 'pdf') || $page === 'rapport.fiche') {
            $reponse->assertHeader('Content-Type', 'application/pdf');
        }
    }
}
