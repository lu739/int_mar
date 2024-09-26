<?php

namespace Tests\Feature\App\Http\Controllers;

use App\Http\Controllers\HomeController;
use Database\Factories\BrandFactory;
use Database\Factories\CategoryFactory;
use Database\Factories\ProductFactory;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class HomeControllerTest extends TestCase
{
    use refreshDatabase;

    public function test_seccess_response()
    {
        BrandFactory::new()
            ->count(10)
            ->create([
                'on_home_page' => true,
                'sorting' => 999
            ]);
        $brand = BrandFactory::new()
            ->createOne([
                'on_home_page' => true,
                'sorting' => 1
            ]);

        ProductFactory::new()
            ->count(10)
            ->create([
                'on_home_page' => true,
                'sorting' => 999
            ]);
        $product = ProductFactory::new()
            ->createOne([
                'on_home_page' => true,
                'sorting' => 1
            ]);

        CategoryFactory::new()
            ->count(10)
            ->create([
                'on_home_page' => true,
                'sorting' => 999
            ]);
        $category = CategoryFactory::new()
            ->createOne([
                'on_home_page' => true,
                'sorting' => 1
            ]);

        $this->get(action([HomeController::class]))
            ->assertOk()
            ->assertViewHas('categories.0', $category)
            ->assertViewHas('brands.0', $brand)
            ->assertViewHas('products.0', $product);
    }
}
