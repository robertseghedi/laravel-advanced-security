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
        if ($this->app->runningInConsole()) {
        // Export the migration
            if(! class_exists('create_robertseghedi_secure_logs')) {
                $this->publishes([
                __DIR__ . '/database/migrations/create_robertseghedi_secure_logs.php.stub' => database_path('migrations/' . date('Y_m_d_His', time()) . '_create_robertseghedi_secure_logs.php'),
                // you can add any number of migrations here
                ], 'migrations');
                $this->loadMigrationsFrom(__DIR__ . '/database/migrations');
            }
        }
    }
}
