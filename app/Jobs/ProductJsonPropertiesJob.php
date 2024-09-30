<?php

namespace App\Jobs;

use App\Models\Product;
use App\Models\Property;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProductJsonPropertiesJob implements ShouldQueue, ShouldBeUnique
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(public Product $product)
    {
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $properties = $this->product->properties->mapWithKeys(function (Property $property) {
            return [$property->title => $property->pivot->value];
        });

        $this->product->updateQuietly(['json_properties' => $properties]);
    }

    public function uniqueId(): string
    {
        return $this->product->id;
    }
}
