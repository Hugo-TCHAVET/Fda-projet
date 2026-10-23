<?php

namespace Tests\Unit;

use App\Enums\EtatDemande;
use App\Support\MigrationEtat;
use PHPUnit\Framework\TestCase;

class MigrationEtatTest extends TestCase
{
    /**
     * @dataProvider drapeaux
     */
    public function test_etat_depuis_drapeaux(?string $valide, ?string $suspendre, EtatDemande $attendu): void
    {
        $this->assertSame($attendu, MigrationEtat::depuisDrapeaux($valide, $suspendre));
    }

    public static function drapeaux(): array
    {
        return [
            'en attente' => ['0', '0', EtatDemande::EnAttente],
            'transmise' => ['1', '0', EtatDemande::Transmise],
            'transmise puis suspendue' => ['1', '1', EtatDemande::Suspendue],
            'suspendue sans transmission' => ['0', '1', EtatDemande::Suspendue],
            'approuvée' => ['2', '0', EtatDemande::Approuvee],
            'approuvée puis suspendue' => ['2', '1', EtatDemande::Approuvee],
            'drapeaux absents' => [null, null, EtatDemande::EnAttente],
        ];
    }

    public function test_libelles(): void
    {
        $this->assertSame('En attente', EtatDemande::EnAttente->libelle());
        $this->assertSame('En cours de traitement', EtatDemande::Transmise->libelle());
        $this->assertSame('Suspendue', EtatDemande::Suspendue->libelle());
        $this->assertSame('Approuvée', EtatDemande::Approuvee->libelle());
    }
}
