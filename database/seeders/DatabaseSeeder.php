<?php

namespace Database\Seeders;

use App\Models\Client;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create Super Admin
        $superAdmin = User::factory()->create([
            'name' => 'Super Admin',
            'email' => 'superadmin@example.com',
            'password' => Hash::make('password'),
            'role' => 'super_admin',
        ]);
        // Create regular users
        $users = User::factory(5)->create();

        // Create clients
        $clients = Client::factory(10)->create();

        // Create invoices for each user with their clients
        $users->each(function ($user) use ($clients) {
            // Assign some clients to this user
            $userClients = $clients->random(rand(2, 5));

            foreach ($userClients as $client) {
                // Create 1-3 invoices per client
                $invoices = Invoice::factory()
                    ->count(rand(1, 3))
                    ->for($client)
                    ->for($user)
                    ->create();

                // Add 1-5 invoice items per invoice
                foreach ($invoices as $invoice) {
                    $items = InvoiceItem::factory()
                        ->count(rand(1, 5))
                        ->for($invoice)
                        ->create();

                    // Update invoice total based on items
                    $invoice->update([
                        'total' => $items->sum('total_amount')
                    ]);
                }
            }
        });
    }
}
