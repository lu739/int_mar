<?php

namespace Tests\Feature\App\Jobs;

use App\Jobs\ProductJsonPropertiesJob;
use Database\Factories\BrandFactory;
use Database\Factories\ProductFactory;
use Database\Factories\PropertyFactory;
use Illuminate\Support\Facades\Queue;
use Tests\TestCase;

class ProductJsonPropertiesJobTest extends TestCase
{
    public function test_job(): void
    {
        $queue = Queue::getFacadeRoot();

        Queue::fake([ProductJsonPropertiesJob::class]);

        $properties = PropertyFactory::new()
            ->count(10)
            ->create();

        $product = ProductFactory::new()
            ->hasAttached($properties, function () {
                return ['value' => fake()->word()];
            })
            ->create();

        $this->assertEmpty($product->json_properties);

        Queue::swap($queue);

        ProductJsonPropertiesJob::dispatchSync($product);

        $product->refresh();

        $this->assertNotEmpty($product->json_properties);
    }
}
