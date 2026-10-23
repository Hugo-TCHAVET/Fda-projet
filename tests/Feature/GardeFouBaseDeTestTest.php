<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\DB;
use RuntimeException;
use Tests\TestCase;

class GardeFouBaseDeTestTest extends TestCase
{
    public function test_base_sans_suffixe_test_refusee(): void
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('basefda');

        static::verifierBaseDeTest('basefda');
    }

    public function test_base_nulle_refusee(): void
    {
        $this->expectException(RuntimeException::class);

        static::verifierBaseDeTest(null);
    }

    public function test_base_controlee_est_celle_de_la_connexion(): void
    {
        $connexion = config('database.default');
        config(["database.connections.{$connexion}.url" => 'mysql://root:root@127.0.0.1:3307/base_de_production']);
        DB::purge($connexion);

        try {
            $this->assertSame('base_de_production', static::baseCourante());
        } finally {
            config(["database.connections.{$connexion}.url" => null]);
            DB::purge($connexion);
        }
    }

    public function test_base_de_test_acceptee(): void
    {
        static::verifierBaseDeTest('basefda_test');

        $this->addToAssertionCount(1);
    }
}
