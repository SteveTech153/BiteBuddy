<?php

namespace Database\Factories;

use App\Models\Hotel;
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
        $generateAddress = function (){
            return [
                'flat_no' => $this->faker->buildingNumber,
                'street' => $this->faker->streetName,
                'state' => $this->faker->state,
                'pincode' => $this->faker->postcode,
            ];
        };
        return [
            'customer_id' => User::factory(),
            'delivery_id' => null,
            'hotel_id' => Hotel::factory(),
            'total_amount' => $this->faker->randomFloat(2, 10, 200),
            'status' => $this->faker->randomElement(['pending', 'confirmed', 'in_progress', 'delivered', 'canceled']),
            'address' => json_encode($generateAddress()),
        ];
    }
}
