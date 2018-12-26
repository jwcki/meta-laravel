<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Services\Interfaces\OmdbAPIService;
use App\Services\SimpleOmdbAPIService;

class OmdbAPIServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(OmdbAPIService::class, function ($app) {
            return new SimpleOmdbAPIService(env('OMDB_HOST'), env('OMDB_API_KEY'));
        });    
    }
}
