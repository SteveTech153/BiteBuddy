<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Hotel>
 */
class HotelFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->company,
            'location' => $this->faker->address,
            'phone' => $this->faker->phoneNumber,
            'address' => $this->faker->address,
            'opening_time' => $this->faker->time('H:i:s'),
            'closing_time' => $this->faker->time('H:i:s'),
            'user_id' => User::factory(),
        ];
    }
}
