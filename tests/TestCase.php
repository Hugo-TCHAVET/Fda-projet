<?php

namespace Tests;

use App\Models\Demande;
use Illuminate\Database\Eloquent\MissingAttributeException;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\DB;
use RuntimeException;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    // A renamed or dropped demandes column read through the model throws instead of rendering as empty.
    // Limited to Demande: Jetstream's User reads two_factor_confirmed_at, which this schema lacks.
    protected function setUp(): void
    {
        parent::setUp();
        Model::preventAccessingMissingAttributes();
        Model::handleMissingAttributeViolationUsing(function (Model $modele, string $attribut) {
            if ($modele instanceof Demande) {
                throw new MissingAttributeException($modele, $attribut);
            }

            return null;
        });
    }

    // RefreshDatabase runs in setUpTraits(): check the database before it can be wiped.
    protected function setUpTraits()
    {
        static::verifierBaseDeTest(static::baseCourante());

        return parent::setUpTraits();
    }

    // The connection's name, not the config key: DATABASE_URL overrides DB_DATABASE when connecting.
    protected static function baseCourante(): ?string
    {
        return DB::connection()->getDatabaseName();
    }

    protected static function verifierBaseDeTest(?string $base): void
    {
        if ($base === null || ! str_ends_with($base, '_test')) {
            throw new RuntimeException("Tests refusés : la base « {$base} » n'est pas une base de test (suffixe _test attendu).");
        }
    }
}
