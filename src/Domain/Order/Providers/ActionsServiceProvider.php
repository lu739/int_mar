<?php

namespace Domain\Order\Providers;

use Illuminate\Support\ServiceProvider;

class ActionsServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->register(
            ActionsServiceProvider::class
        );
    }
}
