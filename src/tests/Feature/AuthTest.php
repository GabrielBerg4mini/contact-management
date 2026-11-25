<?php

namespace Tests\Feature;

use App\Models\Contact;
use App\Models\User;
use Database\Seeders\AdminUserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_can_view_the_list(): void
    {
        Contact::factory()->create(['name' => 'Fulano de Tal']);

        $this->get(route('contacts.index'))->assertOk()->assertSee('Fulano de Tal');
    }

    public function test_guest_is_redirected_to_login_on_protected_pages(): void
    {
        $contact = Contact::factory()->create();

        $this->get(route('contacts.create'))->assertRedirect(route('login'));
        $this->get(route('contacts.show', $contact))->assertRedirect(route('login'));
        $this->get(route('contacts.edit', $contact))->assertRedirect(route('login'));
        $this->post(route('contacts.store'), [])->assertRedirect(route('login'));
        $this->put(route('contacts.update', $contact), [])->assertRedirect(route('login'));
        $this->delete(route('contacts.destroy', $contact))->assertRedirect(route('login'));

        $this->assertDatabaseHas('contacts', ['id' => $contact->id, 'deleted_at' => null]);
    }

    public function test_admin_can_login_with_seeded_credentials(): void
    {
        $this->seed(AdminUserSeeder::class);

        $this->post('/login', ['email' => 'admin@admin.com', 'password' => '123456'])
            ->assertRedirect(route('contacts.index'));

        $this->assertAuthenticated();
    }

    public function test_login_fails_with_wrong_password(): void
    {
        $this->seed(AdminUserSeeder::class);

        $this->from('/login')
            ->post('/login', ['email' => 'admin@admin.com', 'password' => 'errada'])
            ->assertRedirect('/login')
            ->assertSessionHasErrors('email');

        $this->assertGuest();
    }

    public function test_user_returns_to_intended_page_after_login(): void
    {
        $this->seed(AdminUserSeeder::class);

        $this->get(route('contacts.create'))->assertRedirect(route('login'));

        $this->post('/login', ['email' => 'admin@admin.com', 'password' => '123456'])
            ->assertRedirect(route('contacts.create'));
    }

    public function test_logout(): void
    {
        $this->actingAs(User::factory()->create())
            ->post(route('logout'))
            ->assertRedirect(route('contacts.index'));

        $this->assertGuest();
    }
}
