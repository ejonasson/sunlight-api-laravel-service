<?php

namespace ejonasson\SunlightAPI;

use ejonasson\SunlightAPI\API\CongressAPIRequest;
use ejonasson\SunlightAPI\API\CapitolWordsAPIRequest;
use ejonasson\SunlightAPI\API\OpenStatesAPIRequest;
use ejonasson\SunlightAPI\API\PartyTimeAPIRequest;
use ejonasson\SunlightAPI\API\CampaignFinanceAPIRequest;
use ejonasson\SunlightAPI\Exception\SunlightAPIException;

/**
 * SunlightAPI class.
 *
 * @class           SunlightAPI
 * @author          <ejonasson@gmail.com>
 * @version         1.0.0
 *
 * @history
 *
 *
 */
class SunlightAPI
{

    public function __construct($config = [])
    {
    // You may comment this line if you application doesn't support the config
        if (empty($config)) {
            throw new \RunTimeException('Sunlight API Facade configuration is empty. Please run `php artisan vendor:publish`');
        }
    }

    public static function makeRequest($api, $endpoint = '', $parameters = array())
    {
        switch ($api) {
            case 'congress':
                return new CongressAPIRequest($endpoint, $parameters);
                break;
            case 'capitol-words':
                return new CapitolWordsAPIRequest($endpoint, $parameters);
                break;
            case 'open-states':
                return new OpenStatesAPIRequest($endpoint, $parameters);
                break;
            case 'political-party-time':
                return new PartyTimeAPIRequest($endpoint, $parameters);
                break;
            case 'campaign-finance':
                return new CampaignFinanceAPIRequest($endpoint, $parameters);
            default:
                throw new SunlightAPIException("The {$api} API does not exist or is not supported");
                break;
        }
    }
}
