<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Restaurant>
 */
class RestaurantFactory extends Factory
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
            'phone' => $this->faker->phoneNumber,
            'address' => $this->faker->address,
            'opening_time' => $this->faker->time('H:i:s'),
            'closing_time' => $this->faker->time('H:i:s'),
            'image' => 'https://www.google.com/url?sa=i&url=https%3A%2F%2Fwww.freepik.com%2Ffree-photos-vectors%2Frestaurant-cartoon&psig=AOvVaw2TT9OsREtP9PfUOtdmZbSf&ust=1701967561327000&source=images&cd=vfe&ved=0CBIQjRxqFwoTCMDz-bCh-4IDFQAAAAAdAAAAABAE',
            'user_id' => User::factory(),
        ];
    }
}
