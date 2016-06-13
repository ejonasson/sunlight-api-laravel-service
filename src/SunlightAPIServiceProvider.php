<?php

namespace ejonasson\SunlightAPI;

use Illuminate\Support\Facades\App;
use Illuminate\Support\ServiceProvider;

class SunlightAPIServiceProvider extends ServiceProvider
{
    public function boot()
    {
        // will copy the default configuration in the laravel project
        $this->publishes([ __DIR__ . '/config/sunlightapi.php' => config_path('sunlightapi.php')]);
    }

    /**
    * Register the service provider.
    *
    * @return void
    */
    public function register()
    {

    // See src/Facades/SunlightAPIFacade.php
        App::bind('ejonasson.sunlightapi.laravel.facade', function () {

        // Feel free to comment this section if you no need of configuration
            $config = config('sunlightapi');

            if (!$config) {
                throw new \RunTimeException('Sunlight API configuration not found. Please run `php artisan vendor:publish`');
            }

            // DO NOT REMOVE or COMMENT - here we'll create the Facade
            // Remove $config if you have comment the lines above
            return new \ejonasson\SunlightAPI\SunlightAPI($config);
        });
    }
}
