<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Demande;
use App\Models\DemandeLocalisation;
use App\Models\Departement;
use App\Models\Commune;
use Faker\Factory as Faker;

class DemandeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('fr_FR');

        // Créer 10 demandes
        $demandes = Demande::factory()
            ->count(5)
            ->create();

        // Pour chaque demande, créer 0 à 2 localisations
        foreach ($demandes as $demande) {
            $nbLocalisations = rand(0, 2);

            for ($i = 0; $i < $nbLocalisations; $i++) {
                $departement = Departement::inRandomOrder()->first();
                $commune = $departement
                    ? Commune::where('departement_id', $departement->id)->inRandomOrder()->first()
                    : null;

                if ($departement && $commune) {
                    DemandeLocalisation::create([
                        'demande_id' => $demande->id,
                        'departement_id' => $departement->id,
                        'commune_id' => $commune->id,
                        'lieux' => $faker->streetAddress(),
                        'homme_touche' => rand(50, 300),
                    ]);
                }
            }
        }

        $this->command->info('10 demandes avec leurs localisations ont été créées avec succès !');
    }
}
