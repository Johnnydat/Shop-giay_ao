<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->words(3, true),
            'price' => $this->faker->randomFloat(2, 100, 5000),
            'image' => $this->faker->imageUrl(640, 480, 'products', true),
            'category_id' => Category::inRandomOrder()->first()?->id ?? Category::factory(),
            'status' => $this->faker->boolean(80) ? 1 : 0,
            'stock' => $this->faker->numberBetween(10, 100),
            'views' => $this->faker->numberBetween(0, 1000),
            'description' => $this->faker->paragraph(3),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
