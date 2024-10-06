<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\User::class)
                ->nullable()
                ->constrained()
                ->cascadeOnUpdate()
                ->nullOnDelete();

            $table->foreignIdFor(\App\Models\DeliveryType::class)
                ->constrained();
            $table->foreignIdFor(\App\Models\PaymentMethod::class)
                ->constrained();

            $table->enum('status', array_column(\Domain\Order\Enums\OrderStatusEnum::cases(), 'value'))
                ->default(\Domain\Order\Enums\OrderStatusEnum::NEW->value);

            $table->unsignedInteger('amount')->default(0);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        if (!app()->isProduction()) {
            Schema::dropIfExists('orders');
        }
    }
};
