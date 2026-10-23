<?php

namespace Tests\Feature;

use App\Models\Demande;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class SchemaProductionTest extends TestCase
{
    use RefreshDatabase;

    // Transitional: shrink this list when a column or table listed here is dropped.
    private const COLONNES_NULLABLES = [
        'demandes' => ['archivee', 'budget_accorde', 'commune', 'contact', 'debut_activite', 'departement', 'duree_activite', 'fin_activite', 'homme_touche', 'lieux', 'piece', 'rapport_depose'],
        'demande_localisations' => ['homme_touche'],
    ];

    public function test_colonnes_nullables_comme_en_production(): void
    {
        foreach (self::COLONNES_NULLABLES as $table => $colonnes) {
            foreach ($colonnes as $colonne) {
                $nullable = DB::table('information_schema.columns')
                    ->where('table_schema', DB::getDatabaseName())
                    ->where('table_name', $table)
                    ->where('column_name', $colonne)
                    ->value('is_nullable');

                $this->assertSame('YES', $nullable, "{$table}.{$colonne} devrait accepter NULL");
            }
        }
    }

    public function test_femme_touche_absente_de_demandes(): void
    {
        $this->assertFalse(Schema::hasColumn('demandes', 'femme_touche'));
    }

    public function test_demande_minimale_comme_le_formulaire(): void
    {
        $demande = Demande::create([
            'code' => 'A01-TEST',
            'structure' => 'Atelier Test',
            'service' => 'Formation',
            'type_demande' => 'structure',
            'nom' => 'Doe',
            'prenom' => 'Jane',
            'sexe' => 'Féminin',
            'ifu' => '1234567890123',
            'titre_activite' => 'Titre',
            'objectif_activite' => 'Objectif',
            'budget' => '500000',
        ]);

        $this->assertDatabaseHas('demandes', ['id' => $demande->id, 'piece' => null]);
    }
}
