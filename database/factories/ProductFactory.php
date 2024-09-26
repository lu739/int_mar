<?php

namespace Database\Factories;

use App\Models\Brand;
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
            'title' => $this->faker->sentence(3),
            'thumbnail' => $this->faker->file(
                base_path('tests/Fixtures/images/products'),
                storage_path('app/public/images/products'),
                false
            ),
            'price' => $this->faker->numberBetween(1000, 99999),
            'brand_id' => Brand::query()->inRandomOrder()->first()->id,
            'on_home_page' => $this->faker->boolean,
            'sorting' => $this->faker->numberBetween(1, 999),
        ];
    }
}
