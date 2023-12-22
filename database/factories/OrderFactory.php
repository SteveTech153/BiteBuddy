<?php

namespace Database\Factories;

use App\Models\Restaurant;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Faker\Generator as Faker;
use App\Models\Order;
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
            'customer_id' => User::factory(),
            'delivery_id' => null,
            'restaurant_id' => Restaurant::factory(),
            'total_amount' => $this->faker->randomFloat(2, 10, 200),
            'status' => $this->faker->randomElement(['pending', 'confirmed', 'in_progress', 'delivered', 'canceled']),
            'address' => $this->faker->address(),
            'city_id' => $this->faker->numberBetween(1, 3),
        ];
    }
}
