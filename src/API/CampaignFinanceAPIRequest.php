<?php

namespace ejonasson\SunlightAPI\API;

use ejonasson\SunlightAPI\API\APIRequest;
use ejonasson\SunlightAPI\Exception\SunlightAPIException;

class CampaignFinanceAPIRequest extends APIRequest
{
    protected $url = 'http://realtime.influenceexplorer.com/api/';

    public function __construct($endpoint = '', $args = array())
    {
        parent::__construct($endpoint, $args);
        // Add the slash to the endpoint
        $this->endpoint = rtrim($this->endpoint, '/') . '/';
    }

    public function getUrl()
    {
        return $this->url;
    }

    public function getPrevious()
    {
        if (!$this->response) {
            throw new SunlightAPIException('Cannot use "getPrevious" without having run initial query');
        }
                
        if ($this->args['page'] > 0) {
            $this->args['page']--;
        }
        
        return $this->request();
    }

    public function getNext()
    {
        if (!$this->response) {
            throw new SunlightAPIException('Cannot use "getNext" without having run initial query');
        }
        $this->args['page']++;
        
        return $this->request();
    }
    public function setInitialArgs($args)
    {
        $args['page'] = isset($args['page']) ? $args['page'] : 1;
        $args['format'] = isset($args['format']) ? $args['format'] : 'json';
        return $args;
    }
}
