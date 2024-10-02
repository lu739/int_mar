<?php

namespace Domain\Cart\Providers;

use Domain\Auth\Providers\ActionsServiceProvider;
use Domain\Cart\CartManager;
use Domain\Cart\Contracts\CartIdentityStorageContract;
use Domain\Cart\StorageIdentities\SessionIdentityStorage;
use Illuminate\Support\ServiceProvider;

class CartServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(CartManager::class);
        $this->app->bind(
            CartIdentityStorageContract::class,
            SessionIdentityStorage::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
    }
}
