<?php

namespace Tests\Feature;

use App\Models\Client;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class InvoiceItemsTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;
    protected Client $client;
    protected Invoice $invoice;

    protected function setUp(): void
    {
        parent::setUp();

        // Create a user with super admin role
        $this->user = User::factory()->create([
            'role' => 'super_admin',
        ]);

        // Create a client
        $this->client = Client::factory()->create();

        // Create an invoice
        $this->invoice = Invoice::factory()->create([
            'user_id' => $this->user->id,
            'client_id' => $this->client->id,
        ]);
    }

    public function test_can_view_invoice_items_edit_page(): void
    {
        $response = $this->actingAs($this->user)
            ->get(route('invoices.items.edit', $this->invoice));

        $response->assertStatus(200);
        $response->assertInertia(fn ($page) => $page
            ->component('Invoices/EditItems')
            ->has('invoice')
        );
    }

    public function test_can_update_invoice_items(): void
    {
        $itemData = [
            'items' => [
                [
                    'id' => null,
                    'name' => 'Web Development',
                    'description' => 'Frontend development',
                    'number_of_days' => '5',
                    'number_of_hours' => '8',
                    'day_rate' => '500',
                    'details' => 'Built responsive UI components',
                    'total_amount' => 3000.00,
                ],
            ],
        ];

        $response = $this->actingAs($this->user)
            ->put(route('invoices.items.update', $this->invoice), $itemData);

        $response->assertRedirect(route('invoices.items.edit', $this->invoice));
        $response->assertSessionHas('success', 'Invoice items updated successfully.');

        $this->assertDatabaseHas('invoice_items', [
            'invoice_id' => $this->invoice->id,
            'name' => 'Web Development',
            'description' => 'Frontend development',
        ]);
    }

    public function test_can_add_multiple_items(): void
    {
        $itemData = [
            'items' => [
                [
                    'id' => null,
                    'name' => 'Web Development',
                    'description' => 'Frontend',
                    'number_of_days' => '5',
                    'number_of_hours' => '0',
                    'day_rate' => '500',
                    'details' => 'Frontend work',
                    'total_amount' => 2500.00,
                ],
                [
                    'id' => null,
                    'name' => 'Backend Development',
                    'description' => 'API Development',
                    'number_of_days' => '3',
                    'number_of_hours' => '4',
                    'day_rate' => '600',
                    'details' => 'Backend API work',
                    'total_amount' => 2100.00,
                ],
            ],
        ];

        $response = $this->actingAs($this->user)
            ->put(route('invoices.items.update', $this->invoice), $itemData);

        $response->assertRedirect();
        $this->assertEquals(2, $this->invoice->fresh()->items()->count());
    }

    public function test_can_delete_items(): void
    {
        // Create initial items
        $item1 = InvoiceItem::factory()->create([
            'invoice_id' => $this->invoice->id,
        ]);
        $item2 = InvoiceItem::factory()->create([
            'invoice_id' => $this->invoice->id,
        ]);

        // Update with only one item (removing item2)
        $itemData = [
            'items' => [
                [
                    'id' => $item1->id,
                    'name' => $item1->name,
                    'description' => $item1->description,
                    'number_of_days' => $item1->number_of_days,
                    'number_of_hours' => $item1->number_of_hours,
                    'day_rate' => $item1->day_rate,
                    'details' => $item1->details,
                    'total_amount' => $item1->total_amount,
                ],
            ],
        ];

        $response = $this->actingAs($this->user)
            ->put(route('invoices.items.update', $this->invoice), $itemData);

        $response->assertRedirect();
        $this->assertEquals(1, $this->invoice->fresh()->items()->count());
        $this->assertDatabaseMissing('invoice_items', ['id' => $item2->id]);
    }

    public function test_invoice_total_is_recalculated(): void
    {
        $itemData = [
            'items' => [
                [
                    'id' => null,
                    'name' => 'Item 1',
                    'description' => 'Description 1',
                    'number_of_days' => '5',
                    'number_of_hours' => '0',
                    'day_rate' => '500',
                    'details' => 'Details 1',
                    'total_amount' => 2500.00,
                ],
                [
                    'id' => null,
                    'name' => 'Item 2',
                    'description' => 'Description 2',
                    'number_of_days' => '3',
                    'number_of_hours' => '0',
                    'day_rate' => '600',
                    'details' => 'Details 2',
                    'total_amount' => 1800.00,
                ],
            ],
        ];

        $this->actingAs($this->user)
            ->put(route('invoices.items.update', $this->invoice), $itemData);

        $this->assertEquals(4300.00, $this->invoice->fresh()->total);
    }

    public function test_validation_requires_at_least_one_item(): void
    {
        $itemData = [
            'items' => [],
        ];

        $response = $this->actingAs($this->user)
            ->put(route('invoices.items.update', $this->invoice), $itemData);

        $response->assertSessionHasErrors(['items']);
    }

    public function test_validation_requires_item_fields(): void
    {
        $itemData = [
            'items' => [
                [
                    'id' => null,
                    'name' => '',
                    'description' => '',
                    'number_of_days' => '',
                    'number_of_hours' => '',
                    'day_rate' => '',
                    'details' => '',
                    'total_amount' => '',
                ],
            ],
        ];

        $response = $this->actingAs($this->user)
            ->put(route('invoices.items.update', $this->invoice), $itemData);

        $response->assertSessionHasErrors([
            'items.0.name',
            'items.0.description',
            'items.0.number_of_days',
            'items.0.number_of_hours',
            'items.0.day_rate',
            'items.0.details',
            'items.0.total_amount',
        ]);
    }

    public function test_can_export_invoice_as_pdf(): void
    {
        // Create an item for the invoice
        InvoiceItem::factory()->create([
            'invoice_id' => $this->invoice->id,
        ]);

        $response = $this->actingAs($this->user)
            ->get(route('invoices.export.pdf', $this->invoice));

        $response->assertStatus(200);
        $response->assertHeader('content-type', 'application/pdf');
    }
}
