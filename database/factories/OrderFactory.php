<?php

namespace Database\Factories;

use App\Models\Cart;
use App\Models\Shipper;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
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
        $dataCart = Cart::all();
        $dataShipper = Shipper::all();

        $cartIds = $dataCart->pluck('id')->toArray();
        $shipperIds = $dataShipper->pluck('id')->toArray();
        return [
            'cart_id' => fake()->randomElement($cartIds),
            //'shipper_id' => fake()->randomElement($shipperIds),
            'created_at' => now(),
            'updated_at' => now()
        ];
    }
}
