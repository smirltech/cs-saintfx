<?php

namespace App\Http\Integrations\Scolarite;

use Cache;
use Sammyjo20\Saloon\Http\SaloonConnector;
use Sammyjo20\Saloon\Traits\Plugins\AcceptsJson;
use Sammyjo20\SaloonCachePlugin\Drivers\LaravelCacheDriver;
use Sammyjo20\SaloonCachePlugin\Interfaces\DriverInterface;
use Sammyjo20\SaloonCachePlugin\Traits\AlwaysCacheResponses;

class ScolariteConnector extends SaloonConnector
{
    use AcceptsJson, AlwaysCacheResponses;

    /**
     * The Base URL of the API.
     *
     * @return string
     */
    public function defineBaseUrl(): string
    {
        return config('services.scolarite.url');
    }

    /**
     * The headers that will be applied to every request.
     *
     * @return string[]
     */
    public function defaultHeaders(): array
    {
        return [];
    }

    /**
     * The config options that will be applied to every request.
     *
     * @return string[]
     */
    public function defaultConfig(): array
    {
        return [];
    }

    public function cacheDriver(): DriverInterface
    {
        return new LaravelCacheDriver(Cache::store('database'));
    }

    public function cacheTTLInSeconds(): int
    {
        if (app()->isProduction()) {
            return 86400; // 24 hours
        }
        return 60; // 1 minute
    }
}
