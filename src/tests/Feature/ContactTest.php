<?php

namespace Tests\Feature;

use App\Models\Contact;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class ContactTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Todas as ações de escrita exigem login.
        $this->actingAs(User::factory()->create());
    }

    private function valid(array $override = []): array
    {
        return array_merge([
            'name' => 'Maria Oliveira',
            'contact' => '912345678',
            'email' => 'maria@example.com',
        ], $override);
    }

    public function test_index_lists_contacts(): void
    {
        Contact::factory()->create(['name' => 'Fulano de Tal']);

        $this->get(route('contacts.index'))->assertOk()->assertSee('Fulano de Tal');
    }

    public function test_can_create_contact(): void
    {
        $this->post(route('contacts.store'), $this->valid())->assertRedirect();

        $this->assertDatabaseHas('contacts', ['email' => 'maria@example.com']);
    }

    public function test_can_update_contact(): void
    {
        $contact = Contact::factory()->create();

        $this->put(route('contacts.update', $contact), $this->valid(['name' => 'Novo Nome Aqui']))
            ->assertRedirect(route('contacts.show', $contact));

        $this->assertDatabaseHas('contacts', ['id' => $contact->id, 'name' => 'Novo Nome Aqui']);
    }

    public function test_delete_is_a_soft_delete(): void
    {
        $contact = Contact::factory()->create();

        $this->delete(route('contacts.destroy', $contact))->assertRedirect(route('contacts.index'));

        $this->assertSoftDeleted('contacts', ['id' => $contact->id]);
    }

    #[DataProvider('invalidData')]
    public function test_store_validation_errors(array $override, string $field): void
    {
        $this->post(route('contacts.store'), $this->valid($override))->assertSessionHasErrors($field);

        $this->assertDatabaseCount('contacts', 0);
    }

    public function test_update_validation_errors(): void
    {
        $contact = Contact::factory()->create();

        $this->put(route('contacts.update', $contact), $this->valid(['name' => 'abc']))
            ->assertSessionHasErrors('name');
    }

    public static function invalidData(): array
    {
        return [
            'nome curto (5 chars)' => [['name' => 'abcde'], 'name'],
            'nome vazio' => [['name' => ''], 'name'],
            'contato com 8 dígitos' => [['contact' => '12345678'], 'contact'],
            'contato com letras' => [['contact' => '12345678a'], 'contact'],
            'e-mail inválido' => [['email' => 'nao-e-email'], 'email'],
        ];
    }

    public function test_contact_and_email_must_be_unique(): void
    {
        Contact::factory()->create(['contact' => '912345678', 'email' => 'maria@example.com']);

        $this->post(route('contacts.store'), $this->valid())
            ->assertSessionHasErrors(['contact', 'email']);
    }

    public function test_editing_keeps_own_unique_values(): void
    {
        $contact = Contact::factory()->create(['contact' => '912345678', 'email' => 'maria@example.com']);

        $this->put(route('contacts.update', $contact), $this->valid())->assertSessionHasNoErrors();
    }

    public function test_soft_deleted_values_can_be_reused(): void
    {
        Contact::factory()->create(['contact' => '912345678', 'email' => 'maria@example.com'])->delete();

        $this->post(route('contacts.store'), $this->valid())->assertSessionHasNoErrors();
    }
}
