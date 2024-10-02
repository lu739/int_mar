<?php

namespace Support;

use App\Events\AfterSessionRegeneratedEvent;
use Closure;
use Illuminate\Support\Facades\Cache;

class SessionRegenerator
{
    public static function run(string $currentSessionId, Closure $callback = null): void
    {
        if (!is_null($callback)) {
            $callback();
        }

        event(new AfterSessionRegeneratedEvent($currentSessionId, session()->getId()));
    }
}
