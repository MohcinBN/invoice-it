<?php

namespace Database\Factories;

use App\Models\Client;
use App\Models\Invoice;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Invoice>
 * @template TModel of Invoice
 * @extends Factory<TModel>
 */
class InvoiceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'client_id' => Client::factory(),
            'user_id' => User::factory(),
            'invoice_number' => 'INV-' . $this->faker->unique()->numberBetween(1000, 9999),
            'invoice_date' => $this->faker->dateTimeBetween('-1 year'),
            'date_covered_start' => $this->faker->dateTimeBetween('-1 year', '+1 month'),
            'date_covered_end' => $this->faker->dateTimeBetween('-1 year', '+1 month'),
            'status' => $this->faker->randomElement(['pending', 'sent', 'paid']),
            'total' => $this->faker->randomFloat(2, 100, 10000),
            'template' => 'template_' . $this->faker->numberBetween(1, 3),
        ];
    }
}
