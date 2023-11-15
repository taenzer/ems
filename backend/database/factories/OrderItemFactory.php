<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\OrderItem>
 */
class OrderItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $q = $this->faker->numberBetween(1, 10);
        $prod = Product::inRandomOrder()->first();
        return [
            "order_id" => Order::factory()->create(),
            "product_id" => $prod->id,
            "name" => $prod->name,
            "price" => $prod->default_price,
            "quantity" => $q,
            "itemTotal" => $prod->default_price * $q,
        ];
    }
}