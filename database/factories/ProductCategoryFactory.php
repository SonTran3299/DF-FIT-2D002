<?php

namespace Database\Factories;

use App\Models\ProductCategory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class ProductCategoryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ProductCategory::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = fake()->name();
        $slug = Str::slug($name);
        return [
            'status' => fake()->boolean(),
            'name' => $name,
            'slug' => $slug,
            'created_at' => now(),
            'updated_at' => now()
        ];
    }

    /**
     *
     *
     * @param string $name
     * @return static
     */
    // public function customCategoryName(string $name): static
    // {
    //     return $this->state(fn(array $attributes) => [
    //         'name' => $name,
    //         'slug' => Str::slug($name),
    //         'status' => fake()->boolean(),
    //         'created_at' => now(),
    //         'updated_at' => now()
    //     ]);
    // }

    /**
     * 
     * 
     *
     * @return void
     */
    public static function customCategoryName(): void
    {
        $imageUrl = "https://picsum.photos/640/480?random=".rand();
        $imageName = "image_".uniqid();
        file_put_contents(public_path('images/category/'.$imageName.'.jpg'),file_get_contents($imageUrl));

        $categories = [
            'truyện tranh',
            'truyện chữ',
            "tiểu thuyết",
            'sách văn học',
            'truyện trinh thám',
            'sách tham khảo',
            'truyện kinh dị',
            'từ điển'
        ];

        foreach ($categories as $categoryName) {
            self::new()->create([ 
                'name' => $categoryName,
                'slug' => Str::slug($categoryName),
                'status' => true,
                'image' => $imageName.'.jpg',
            ]);
        }
    }
}
