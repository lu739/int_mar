<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('slug');
            $table->string('title');
            $table->string('thumbnail')->nullable();
            $table->unsignedInteger('price')->default(0);

            $table->foreignIdFor(\App\Models\Brand::class)
                ->nullable()
                ->constrained()
                ->nullOnDelete()
                ->cascadeOnUpdate();

            $table->unsignedInteger('quantity')->default(0);

            $table->timestamps();
        });

        Schema::create('category_product', function (Blueprint $table) {
            $table->id();

            $table->foreignIdFor(\App\Models\Product::class)
                ->constrained()
                ->cascadeOnDelete()
                ->cascadeOnUpdate();

            $table->foreignIdFor(\App\Models\Category::class)
                ->constrained()
                ->cascadeOnDelete()
                ->cascadeOnUpdate();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (!app()->isProduction()) {
            Schema::dropIfExists('category_product');
            Schema::dropIfExists('products');
        }
    }
};
