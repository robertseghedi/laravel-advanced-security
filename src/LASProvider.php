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
        if (! class_exists('CreateSecureLogsTab')) {
            $this->publishes([
            __DIR__ . '/../database/migrations/createrobert_secure_logs.php.stub' => database_path('migrations/' . date('Y_m_d_His', time()) . '_createrobert_secure_logs.php'),
            // you can add any number of migrations here
            ], 'migrations');
        }
        }
    }
}
