<?php

namespace Database\Factories;

use App\Models\Hotel;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'hotel_id' => Hotel::factory(),
            'name' => $this->faker->sentence(2),
            'description' => $this->faker->paragraph,
            'price' => $this->faker->randomFloat(2, 5, 50),
            'is_vegetarian' => $this->faker->boolean,
            'availability' => true,
            'image' => $this->faker->imageUrl(),
            'category' => $this->faker->word,
        ];
    }
}
