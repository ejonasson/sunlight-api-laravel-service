<?php

return [

  /*
  |--------------------------------------------------------------------------
  | Sunlight API Configuration Options
  |--------------------------------------------------------------------------
  |
  | This file will copy in Laravel config folder when published.
  |
  */
  /**
   * Set the API Key for your app
   * We recommend setting this in your .env file
   */
  'sunlight_api_key' => env('SUNLIGHT_FOUNDATION_API_KEY', ''),

  /**
   * Set the duration of the cache for Sunlight API Requests
   */
  'cache_duration' => 60,

];
