<?php

namespace Database\Factories;

use App\Models\Demande;
use App\Models\Brache;
use App\Models\Corp;
use App\Models\Metier;
use App\Models\Departement;
use App\Models\Commune;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Demande>
 */
class DemandeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $services = ['Assistance', 'Formation'];
        $types = ['professionnel', 'structure', 'ONG'];
        $sexes = ['Masculin', 'Féminin'];

        $debut = $this->faker->dateTimeBetween('now', '+1 month');
        $fin = $this->faker->dateTimeBetween($debut, '+3 months');
        $duree = $debut->diff($fin)->days;

        // Récupérer des IDs existants ou utiliser null
        $brancheId = Brache::inRandomOrder()->first()?->id;
        $corpId = $brancheId ? Corp::where('branche_id', $brancheId)->inRandomOrder()->first()?->id : null;
        $metierId = $brancheId ? Metier::where('branche_id', $brancheId)->inRandomOrder()->first()?->id : null;

        $departementId = Departement::inRandomOrder()->first()?->id;
        $communeId = $departementId ? Commune::where('departement_id', $departementId)->inRandomOrder()->first()?->id : null;

        $budget = $this->faker->numberBetween(100000, 5000000);
        $budgetPrevu = $this->faker->numberBetween(50000, $budget);

        // Dates dans l'année en cours pour pouvoir clôturer
        $createdAt = $this->faker->dateTimeBetween('2024-01-01', '2024-12-31');

        return [
            'code' => strtoupper($this->faker->bothify('?##-????-????-????')),
            'structure' => $this->faker->company(),
            'service' => $this->faker->randomElement($services),
            'type_demande' => $this->faker->randomElement($types),
            'branche' => $brancheId ? (string) $brancheId : null,
            'corps' => $corpId ? (string) $corpId : null,
            'metier' => $metierId ? (string) $metierId : null,
            'nom' => $this->faker->lastName(),
            'prenom' => $this->faker->firstName(),
            'sexe' => $this->faker->randomElement($sexes),
            'ifu' => $this->faker->numerify('##############'),
            'contact' => $this->faker->phoneNumber(),
            'titre_activite' => $this->faker->sentence(4),
            'obejectif_activite' => $this->faker->paragraph(2),
            'debut_activite' => $debut->format('Y-m-d'),
            'fin_activite' => $fin->format('Y-m-d'),
            'dure_activite' => (string) $duree,
            'departement' => $departementId ? (string) $departementId : null,
            'commune' => $communeId ? (string) $communeId : null,
            'lieux' => $this->faker->streetAddress(),
            'homme_touche' => (string) $this->faker->numberBetween(10, 200),
            'budget' => (string) $budget,
            'piece' => null, // Pas de fichier pour les seeders
            'buget_prevu' =>  null,
            'rapport_depose' => false,
            'effectif_homme_forme' => null,
            'effectif_femme_forme' => null,
            'date_depot_rapport' => null,
            'status' => 'En attente',
            'statut' => null,
            'statuts' => null,
            'valide' => '0',
            'suspendre' => '0',
            'rejeter' => '0',
            'archivee' => false,
            'annee_exercice' => null,
            'date_archivage' => null,
            'message' => null,
            'date_transmission' => null,
            'date_approbation' => null,
            'created_at' => $createdAt,
            'updated_at' => $createdAt,
        ];
    }
}
