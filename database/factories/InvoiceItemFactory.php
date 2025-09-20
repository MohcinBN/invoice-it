<?php

namespace Database\Factories;

use App\Models\Invoice;
use App\Models\InvoiceItem;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<InvoiceItem>
 * @template TModel of InvoiceItem
 * @extends Factory<TModel>
 */
class InvoiceItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $days = $this->faker->numberBetween(1, 30);
        $hours = $this->faker->numberBetween(1, 8);
        $rate = $this->faker->numberBetween(20, 100);
        $total = $days * $hours * $rate;

        return [
            'invoice_id' => Invoice::factory(),
            'name' => $this->faker->sentence(3),
            'description' => $this->faker->paragraph(2),
            'number_of_days' => $days,
            'number_of_hours' => $hours,
            'day_rate' => $rate,
            'details' => $this->faker->paragraphs(3, true),
            'total_amount' => $total,
        ];
    }
}
