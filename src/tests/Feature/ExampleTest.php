<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    /**
     * The root URL redirects to the public contacts list.
     */
    public function test_root_redirects_to_contacts(): void
    {
        $response = $this->get('/');

        $response->assertRedirect('/contacts');
    }
}
