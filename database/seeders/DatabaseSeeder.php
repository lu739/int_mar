<?php

namespace Database\Seeders;

use App\Models\Brand;
use App\Models\Category;
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
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        Brand::factory()->count(20)->create();
        Category::factory()->count(10)->create();
        $products = Product::factory()->count(30)->create();

        foreach ($products as $product) {
            $product->category()->attach(Category::query()->inRandomOrder()->limit(rand(1, 3))->get());
        }
    }
}
