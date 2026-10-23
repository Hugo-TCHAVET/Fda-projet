<?php

namespace Tests\Concerns;

use App\Models\Demande;
use App\Enums\EtatDemande;
use Illuminate\Support\Facades\DB;

trait CreeDonneesReference
{
    protected function creerDonneesReference(): void
    {
        DB::table('departements')->insert(['id' => 1, 'nom' => 'Atlantique']);
        DB::table('communes')->insert(['id' => 1, 'departement_id' => 1, 'nom' => 'Abomey-Calavi']);
        DB::table('branches')->insert([
            ['id' => 1, 'nom' => 'Bois'],
            ['id' => 2, 'nom' => 'Métal'],
        ]);
    }

    protected function creerDemande(array $attributs = []): Demande
    {
        return Demande::factory()->create($attributs);
    }

    protected function creerAllocation(array $attributs): Demande
    {
        return $this->creerDemande(array_merge([
            'etat' => EtatDemande::Approuvee,
            'branche_id' => 1,
            'service' => 'Formation',
            'rapport_depose' => true,
        ], $attributs));
    }

    // A, B: approved with report (B predates handicap data); C: not approved; D: approved, no report.
    protected function creerJeuBeneficiaires(): void
    {
        $this->creerAllocation(['effectif_homme_forme' => 10, 'effectif_femme_forme' => 30, 'effectif_handicape_homme' => 1, 'effectif_handicape_femme' => 3]);
        $this->creerAllocation(['branche_id' => 2, 'service' => 'Assistance', 'effectif_homme_forme' => 5, 'effectif_femme_forme' => 5]);
        $this->creerAllocation(['etat' => EtatDemande::Transmise, 'effectif_homme_forme' => 100, 'effectif_femme_forme' => 100, 'effectif_handicape_homme' => 50, 'effectif_handicape_femme' => 50]);
        $this->creerAllocation(['rapport_depose' => false]);
    }
}
