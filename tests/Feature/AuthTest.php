<?php

namespace Tests\Feature;

use App\Models\Role;
use App\Models\User;
use Database\Seeders\RolesPermissionsSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(RolesPermissionsSeeder::class);
        RateLimiter::clear('');
    }

    private function utilisateur(string $role, array $attributs = []): User
    {
        return User::factory()->create(array_merge([
            'role_id'  => Role::where('nom', $role)->value('id'),
            'password' => 'password',
            'actif'    => true,
        ], $attributs));
    }

    public function test_la_page_de_connexion_s_affiche(): void
    {
        $this->get('/login')->assertOk()->assertSee('All in One by Eva');
    }

    public function test_un_visiteur_est_redirige_vers_la_connexion(): void
    {
        $this->get('/dashboard')->assertRedirect(route('login'));
    }

    public function test_connexion_reussie(): void
    {
        $user = $this->utilisateur('admin');

        $this->post('/login', ['email' => $user->email, 'password' => 'password'])
            ->assertRedirect(route('dashboard'));

        $this->assertAuthenticatedAs($user);
        $this->assertNotNull($user->fresh()->last_login_at);
    }

    public function test_mauvais_mot_de_passe(): void
    {
        $user = $this->utilisateur('admin');

        $this->from('/login')
            ->post('/login', ['email' => $user->email, 'password' => 'faux'])
            ->assertSessionHasErrors('email');

        $this->assertGuest();
    }

    public function test_compte_desactive_ne_peut_pas_se_connecter(): void
    {
        $user = $this->utilisateur('receptionniste', ['actif' => false]);

        $this->post('/login', ['email' => $user->email, 'password' => 'password'])
            ->assertSessionHasErrors('email');

        $this->assertGuest();
    }

    public function test_blocage_apres_trop_de_tentatives(): void
    {
        $user = $this->utilisateur('admin');

        for ($i = 0; $i < 5; $i++) {
            $this->post('/login', ['email' => $user->email, 'password' => 'faux']);
        }

        // Même avec le bon mot de passe, la 6e tentative est bloquée
        $this->post('/login', ['email' => $user->email, 'password' => 'password'])
            ->assertSessionHasErrors('email');

        $this->assertGuest();
    }

    public function test_deconnexion(): void
    {
        $user = $this->utilisateur('admin');

        $this->actingAs($user)->post('/logout')->assertRedirect(route('login'));
        $this->assertGuest();
    }

    public function test_acces_refuse_sans_la_permission(): void
    {
        Route::get('/_test-permission', fn () => 'ok')
            ->middleware(['web', 'auth', 'actif', 'permission:clients.voir']);

        // Le professionnel n'a pas clients.voir
        $this->actingAs($this->utilisateur('professionnel'))
            ->get('/_test-permission')->assertForbidden();

        // La réceptionniste l'a
        $this->actingAs($this->utilisateur('receptionniste'))
            ->get('/_test-permission')->assertOk();

        // L'administratrice a tout
        $this->actingAs($this->utilisateur('admin'))
            ->get('/_test-permission')->assertOk();
    }
}