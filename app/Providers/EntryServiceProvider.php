<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Services\Interfaces\EntryService;
use App\Services\EloquentEntryService;

class EntryServiceProvider extends ServiceProvider
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
        logger:('init');
        $this->app->singleton(EntryService::class, function ($app) {
            return new EloquentEntryService();
        });    
    }
}
