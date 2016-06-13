<?php

namespace ejonasson\SunlightAPI\Facades;

use Illuminate\Support\Facades\Facade;

class SunlightAPIFacade extends Facade
{
  /**
   * Get the registered name of the component.
   * See src/BoilerplateLaravelServiceProvider.php
   *
   * @return string
   */
    protected static function getFacadeAccessor()
    {
        return 'ejonasson.sunlightapi.laravel.facade';
    }
}
