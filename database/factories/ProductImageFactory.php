<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class ProductImageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $imageUrl = "https://picsum.photos/640/480?random=".rand();
        $imageName = "image_".uniqid();
        file_put_contents(public_path('images/product/product_image/'.$imageName.'.jpg'),file_get_contents($imageUrl));

        return [
            'image' => $imageName.'.jpg',
            'product_id' => null,
            'created_at' => now(),
            'updated_at' => now()
        ];
    }
}
