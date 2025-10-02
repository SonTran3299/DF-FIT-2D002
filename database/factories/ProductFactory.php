<?php

namespace Database\Factories;

use App\Models\ProductCategory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
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
        $datas = ProductCategory::all();
        $productCategoryIds = $datas->pluck('id')->toArray();

        $imageUrl = "https://picsum.photos/640/480?random=".rand();
        $imageName = "image_".uniqid();
        file_put_contents(public_path('images/product/main_image/'.$imageName.'.jpg'),file_get_contents($imageUrl));

        $types = ['Truyện tranh', 'Tiểu thuyết', 'Tập thơ', 'Ký sự', 'Sách chuyên ngành', 'Tạp chí', 'Sách tham khảo', 'Truyện trinh thám'];
        $randomType = fake()->randomElement($types);
        $randomVolume = rand(1, 10);
        $name = $randomType . ' quyển ' . $randomVolume;

        return [
            'status' => fake()->boolean(),
            'name' => $name,
            'price' => fake()->randomNumber(6, false),
            'stock' => fake()->randomNumber(3, false),
            'main_image' => $imageName.'.jpg',
            'discount_percentage' => fake()->randomFloat(2, 0, 0.3),
            'description' => fake()->randomHtml(2, 2),
            'product_category_id' => fake()->randomElement($productCategoryIds),
            'created_at' => now(),
            'updated_at' => now()
        ];
    }
}
