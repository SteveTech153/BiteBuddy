<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\City;
use App\Models\Hotel;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(RoleSeeder::class);
        $this->call(AdminSeeder::class);
        // Create users
        $users =  User::factory(10)->create();

        $cities = City::factory(10)->create();

        // Create hotels and associate them with users
        $hotels = Hotel::factory(10)->create([
            'user_id' => $users->random()->id,
            'city_id' => $cities->random()->id,
        ]);

        // Create products and associate them with hotels
        $products = Product::factory(30)->create([
            'hotel_id' => $hotels->random()->id,
        ]);


        // Create orders and associate them with users, hotels, and products
        Order::factory(30)->create([
            'customer_id' => $users->random()->id,
            'hotel_id' => $hotels->random()->id,
        ])->each(function ($order) use ($products) {
            $order->products()->attach(
                $products->random(rand(1, 5))->pluck('id')->toArray(),
                ['quantity' => rand(1, 5)]
            );
        });

    }
}