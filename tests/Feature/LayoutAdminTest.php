<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Concerns\CreeDonneesReference;
use Tests\TestCase;

class LayoutAdminTest extends TestCase
{
    use RefreshDatabase;
    use CreeDonneesReference;

    protected function setUp(): void
    {
        parent::setUp();
        $this->creerDonneesReference();
        $this->actingAs(User::factory()->create(['role' => 'verificateur']));
    }

    public function test_scripts_charges_en_chemin_absolu(): void
    {
        $allocation = $this->creerAllocation(['budget_accorde' => '100000']);

        $this->get(route('demande.budget', $allocation->id))
            ->assertOk()
            ->assertSee(asset('Admin/assets/js/core/jquery.min.js'), false)
            ->assertDontSee('src="Admin/assets/', false);
    }

    public function test_livewire_charge_une_seule_fois(): void
    {
        $html = $this->get(route('post-appui'))->assertOk()->getContent();

        $this->assertSame(1, substr_count($html, 'livewire/livewire.js'));
    }

    public function test_code_de_demonstration_retire(): void
    {
        $this->get(route('home'))
            ->assertOk()
            ->assertDontSee('YOUR_KEY_HERE', false)
            ->assertDontSee('demo.initDashboardPageCharts', false)
            ->assertDontSee('bigDashboardChart', false);
    }
}
