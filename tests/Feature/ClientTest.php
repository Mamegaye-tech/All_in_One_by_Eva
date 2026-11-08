<?php

namespace Tests\Feature;

use App\Enums\Role as RoleEnum;
use App\Models\Client;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ClientTest extends TestCase
{
    use RefreshDatabase;

    private function userWithRole(RoleEnum $role): User
    {
        $model = Role::firstOrCreate(['name' => $role->value], ['label' => $role->label()]);

        return User::factory()->create(['role_id' => $model->id, 'is_active' => true]);
    }

    private function payload(array $override = []): array
    {
        return array_merge([
            'prenom' => 'Awa',
            'nom' => 'Diop',
            'telephone' => '77 123 45 67',
            'preference_communication' => 'whatsapp',
        ], $override);
    }

    public function test_receptionniste_peut_creer_un_client_avec_numero_normalise(): void
    {
        $user = $this->userWithRole(RoleEnum::Receptionniste);

        $this->actingAs($user)->post(route('clients.store'), $this->payload())->assertRedirect();

        $this->assertDatabaseHas('clients', ['nom' => 'Diop', 'telephone' => '221771234567']);
    }

    public function test_indicatif_221_nest_pas_duplique(): void
    {
        $user = $this->userWithRole(RoleEnum::Admin);

        $this->actingAs($user)->post(route('clients.store'), $this->payload(['telephone' => '+221 77 123 45 67']));

        $this->assertDatabaseHas('clients', ['telephone' => '221771234567']);
    }

    public function test_doublon_de_telephone_refuse(): void
    {
        $user = $this->userWithRole(RoleEnum::Admin);
        Client::factory()->create(['telephone' => '221771234567']);

        $this->actingAs($user)->post(route('clients.store'), $this->payload(['telephone' => '771234567']))
            ->assertSessionHasErrors('telephone');

        $this->assertDatabaseCount('clients', 1);
    }

    public function test_professionnel_ne_peut_pas_acceder_aux_clients(): void
    {
        $user = $this->userWithRole(RoleEnum::Professionnel);

        $this->actingAs($user)->get(route('clients.index'))->assertForbidden();
    }

    public function test_seule_ladmin_peut_desactiver_et_exporter(): void
    {
        $client = Client::factory()->create();
        $recep = $this->userWithRole(RoleEnum::Receptionniste);
        $admin = $this->userWithRole(RoleEnum::Admin);

        $this->actingAs($recep)->patch(route('clients.toggle-status', $client))->assertForbidden();
        $this->actingAs($recep)->get(route('clients.export'))->assertForbidden();

        $this->actingAs($admin)->patch(route('clients.toggle-status', $client));
        $this->assertFalse($client->fresh()->actif);
    }
}