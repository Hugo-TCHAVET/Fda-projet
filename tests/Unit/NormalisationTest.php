<?php

namespace Tests\Unit;

use App\Support\Normalisation;
use App\Support\ValeurInvalide;
use PHPUnit\Framework\TestCase;

class NormalisationTest extends TestCase
{
    public function test_audit_normalise_montants(): void
    {
        $this->assertSame(1500000, Normalisation::montant('1 500 000'));
        $this->assertSame(1500000, Normalisation::montant('1.500.000'));
        $this->assertSame(1500000, Normalisation::montant("1\u{00A0}500\u{00A0}000"));
        $this->assertSame(0, Normalisation::montant('0'));
        $this->assertNull(Normalisation::montant(''));
        $this->assertNull(Normalisation::montant(null));
    }

    public function test_montant_non_numerique_refuse(): void
    {
        $this->expectException(ValeurInvalide::class);

        Normalisation::montant('abc');
    }

    /**
     * @dataProvider montantsAmbigus
     */
    public function test_montant_avec_decimales_ou_groupes_irreguliers_refuse(string $valeur): void
    {
        $this->expectException(ValeurInvalide::class);

        Normalisation::montant($valeur);
    }

    public static function montantsAmbigus(): array
    {
        return [
            'centimes avec point' => ['250000.00'],
            'centimes avec virgule' => ['1 500 000,50'],
            'décimale' => ['1,5'],
            'groupe de deux chiffres' => ['15 00 000'],
        ];
    }

    public function test_entier_au_dela_du_maximum_refuse(): void
    {
        $this->assertSame(65535, Normalisation::entier('65535', 65535));

        $this->expectException(ValeurInvalide::class);
        Normalisation::entier('70000', 65535);
    }

    public function test_audit_dates_formats_acceptes(): void
    {
        $this->assertSame('2026-10-05', Normalisation::date('2026-10-05'));
        $this->assertSame('2026-10-05', Normalisation::date('05/10/2026'));
        $this->assertNull(Normalisation::date(null));
        $this->assertNull(Normalisation::date(''));
    }

    public function test_date_impossible_refusee(): void
    {
        $this->expectException(ValeurInvalide::class);

        Normalisation::date('31/02/2026');
    }

    public function test_entier(): void
    {
        $this->assertSame(12, Normalisation::entier('12'));
        $this->assertSame(12, Normalisation::entier(' 12 '));
        $this->assertNull(Normalisation::entier(null));

        $this->expectException(ValeurInvalide::class);
        Normalisation::entier('douze');
    }
}
