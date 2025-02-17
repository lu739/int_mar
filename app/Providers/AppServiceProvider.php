<?php

namespace App\Providers;

use App\Events\AfterSessionRegeneratedEvent;
use App\Filters\BrandFilter;
use App\Filters\PriceFilter;
use Carbon\CarbonInterval;
use Domain\Cart\CartManager;
use Domain\Catalog\Filters\FilterManager;
use Domain\Catalog\Sorter\Sorter;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Http\Kernel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(FilterManager::class);

        $this->app->bind(Sorter::class, function () {
            return new Sorter([
                'title',
                'price',
            ]);
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(30)
                ->by($request->user()?->id ?: $request->ip());
        });

        RateLimiter::for('auth', function (Request $request) {
            return Limit::perMinute(10)
                ->by($request->user()?->id ?: $request->ip());
        });

        Model::shouldBeStrict(!app()->isProduction());

        DB::listen(function ($query) {
            if ($query->time > 1000) {
                logger()
                    ->channel('telegram')
                    ->debug('Query longer than 1s: ' . $query['sql']);
            }
        });

        app(Kernel::class)->whenRequestLifecycleIsLongerThan(
            CarbonInterval::seconds(5), function () {
                logger()
                    ->channel('telegram')
                    ->debug('Request lifecycle is longer than 5 seconds: ' . request()->url());
            }
        );

        app(FilterManager::class)->registerFilters([
            new PriceFilter(),
            new BrandFilter(),
        ]);

        Event::listen(AfterSessionRegeneratedEvent::class, function (AfterSessionRegeneratedEvent $event) {
            cart()->updateStorageId($event->old, $event->new);
        });
    }
}
