# Sunlight Foundation API Service Provider

A Laravel 5 wrapper for the Sunlight Foundation API(http://sunlightfoundation.com/) using Guzzle and Curl. Includes caching support for minimizing API calls.

*This integration has not yet been robustly used/tested in a live environment. Use at your own risk.*

Configuration
------------

Register package service provider and facade in 'config/app.php'

```php
'providers' => [
    ...
    'ejonasson\SunlightAPI\SunlightAPIServiceProvider::class',
]

'aliases' => [
    ...
    'SunlightAPI' => ejonasson\SunlightAPI\Facades\SunlightAPIFacade::class,
]
```

Publish the package's configuration file using **`php artisan vendor:publish`** or simply copy package configuration file and paste into **`config/sunlightapi.php`**


Create Your API Key
------------------------

If you haven't already, you will need to [get an API Key](http://sunlightfoundation.com/api/accounts/register/) from the Sunlight Foundation's website.

Once you have a Key, you can add it directly to the **`config/sunlightapi.php`** file, or add `SUNLIGHT_FOUNDATION_API_KEY=<your-api-key>` to the bottom of the .env file.

Making API Requests
--------------------------

This Wrapper provides access to the following APIs:

* [Congress API](https://sunlightlabs.github.io/congress/)
* [CapitolWords API](http://sunlightlabs.github.io/Capitol-Words/)
* [OpenStates API](http://sunlightlabs.github.io/openstates-api/)
* [Political Party Time API](http://sunlightlabs.github.io/partytime-docs/)
* [Campaign Finance API](http://sunlightlabs.github.io/realtime-docs/)

Here is an example of making request to Congress API:

```php
$request = \SunlightAPI::makeRequest(
    'congress',
    'legislators',
    ['party' => 'D']
);
$legislators = $request->get();
```

This request will return the first page of results for all Legislators with a "party" set to Democrat.

### Selecting your API

The first parameter of the `SunlightAPI::makeRequest` function determines which API is used. Use the following strings to select your API:

* **Congress API**: `congress`
* **CapitolWords API**: `capitol-words`
* **OpenStates API**: `open-states`
* **Political Party Time API**: `political-party-time`
* **Campaign Finance API**: `campaign-finance`

### Setting your Endpoint

The second parameter of the `SunlightAPI::makeRequest()` function sets your API Endpoint. Include this endpoint *without* any trailing slashes. Refer to the API's documentation for specific endpoints

### Setting your Parameters

The third parameter of the `SunlightAPI::makeRequest()` function sets your API Parameters. Pass these into the function as an array.

You can also add these parameters using the `setParam()` method on the API Request Class. So the example above can also be executed using the following code:

```php
$request = \SunlightAPI::makeRequest('congress');
$request->setEndpoint('legislators');
$request->setParam(['party' => 'D']);
$legislators = $request->get();
```

### Pagination

The Sunlight API limits the number of items that can be pulled per API Request. If your request returns multiple pages of items, you can use `$request->getNext()` and `$request->getPrevious()` to navigate between pages of your API Request. Make sure you have run `$request->get()` before using these methods, or an error will occur.

## A Note On Caching

This service uses Laravel's built-in [caching system](https://laravel.com/docs/master/cache). You can use the `cache_duration` setting in this package's config file to set the duration of the cache. If you wish to disable caching, set this `cache_duration` setting to 0. 


Built using [gfazioli's Boilerplace Laravel Facade](https://github.com/gfazioli/Boilerplate-Laravel-Facade)

