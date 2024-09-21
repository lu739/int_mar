<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Brand>
 */
class BrandFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->company(),
            'thumbnail' => url('/storage/images/brands') . '/' . $this->faker->file(
                base_path('tests/Fixtures/images/brands'),
                storage_path('app/public/images/brands'),
                false
            ),
        ];
    }
}
