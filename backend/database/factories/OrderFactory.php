<?php

namespace Database\Factories;

use App\Models\Event;
use App\Models\OrderItem;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            "event_id" => Event::factory()->create(),
            "total" => $this->faker->randomFloat(2),
            "gateway" => array_rand(array("bar", "member", "card"))
        ];
    }
}
