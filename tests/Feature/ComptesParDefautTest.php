<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class ComptesParDefautTest extends TestCase
{
    use RefreshDatabase;

    public function test_comptes_par_defaut_sans_mot_de_passe_connu(): void
    {
        $motDePasse = User::where('email', 'sese@gmail.com')->value('password');

        $this->assertNotNull($motDePasse);
        $this->assertFalse(Hash::check('fdan2024', $motDePasse));
    }
}
