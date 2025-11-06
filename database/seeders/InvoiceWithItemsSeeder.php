<?php

namespace Database\Seeders;

use App\Models\Client;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\User;
use Illuminate\Database\Seeder;

class InvoiceWithItemsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create a super admin user if not exists
        $user = User::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin User',
                'email_verified_at' => now(),
                'password' => bcrypt('password'),
                'role' => 'super_admin',
            ]
        );

        // Create sample clients
        $clients = Client::factory()->count(3)->create();

        // Create invoices with items for each client
        foreach ($clients as $client) {
            $invoice = Invoice::factory()->create([
                'user_id' => $user->id,
                'client_id' => $client->id,
                'invoice_number' => 'INV-' . str_pad($client->id, 5, '0', STR_PAD_LEFT),
                'status' => fake()->randomElement(['pending', 'sent', 'paid']),
                'template' => 'template_1',
            ]);

            // Create 2-5 items for each invoice
            $itemsCount = rand(2, 5);
            $items = [];

            for ($i = 0; $i < $itemsCount; $i++) {
                $days = rand(1, 10);
                $hours = rand(0, 7);
                $rate = rand(300, 800);
                $total = ($days * $rate) + (($hours / 8) * $rate);

                $items[] = InvoiceItem::factory()->create([
                    'invoice_id' => $invoice->id,
                    'name' => fake()->randomElement([
                        'Web Development',
                        'Mobile App Development',
                        'UI/UX Design',
                        'Backend Development',
                        'Database Design',
                        'API Integration',
                        'Testing & QA',
                        'Project Management',
                        'Consulting',
                        'Code Review',
                    ]),
                    'description' => fake()->sentence(6),
                    'number_of_days' => (string) $days,
                    'number_of_hours' => (string) $hours,
                    'day_rate' => (string) $rate,
                    'details' => fake()->paragraph(3),
                    'total_amount' => $total,
                ]);
            }

            // Update invoice total
            $invoice->update([
                'total' => $invoice->items()->sum('total_amount'),
            ]);
        }

        $this->command->info('Created ' . $clients->count() . ' invoices with items.');
        $this->command->info('Login credentials: admin@example.com / password');
    }
}
