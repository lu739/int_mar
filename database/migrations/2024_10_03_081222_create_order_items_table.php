<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\Order::class)
                ->constrained()
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->foreignIdFor(\App\Models\Product::class)
                ->constrained()
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->unsignedInteger('quantity');
            $table->unsignedInteger('price');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        if (!app()->isProduction()) {
            Schema::dropIfExists('order_items');
        }
    }
};
