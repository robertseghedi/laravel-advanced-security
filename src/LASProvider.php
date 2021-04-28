<?php

namespace RobertSeghedi\LAS;

use Illuminate\Support\ServiceProvider;

class LASProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->make('RobertSeghedi\LAS\Models\LAS');
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
    }
}
