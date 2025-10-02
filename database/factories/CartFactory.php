<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class CartFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $dataUser = User::all();
        $dataProduct = Product::all();

        $userIds = $dataUser->pluck('id')->toArray();
        $productIds = $dataProduct->pluck('id')->toArray();
        return [
            'user_id' => fake()->randomElement($userIds),
            'product_id' => fake()->randomElement($productIds),
            'quantity' => fake()->randomNumber(3, false),
            'created_at' => now(),
            'updated_at' => now()
        ];
    }
}
