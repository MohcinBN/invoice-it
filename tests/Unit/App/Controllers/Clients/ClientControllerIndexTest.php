<?php

namespace Tests\Unit\App\Controllers\Clients;

use Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ClientControllerIndexTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function it_returns_index_view_with_clients_for_super_admin()
    {
        $this->actingAs(
            User::factory()->create([
                'role' => 'super_admin',
            ]),
        );

        $response = $this->get('/clients');

        $response->assertStatus(200);
    }
}
