<?php

namespace ejonasson\SunlightAPI\API;

use ejonasson\SunlightAPI\API\APIRequest;
use ejonasson\SunlightAPI\Exception\SunlightAPIException;

class CapitolWordsAPIRequest extends APIRequest
{
    protected $url = 'http://capitolwords.org/api/1/';

    public function __construct($endpoint = '', $args = array())
    {
        parent::__construct($endpoint, $args);
        // Add .json to the endpoint for this API
        if (strpos($this->endpoint, '.json') === false) {
            $this->endpoint = $this->endpoint . '.json';
        }
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
        
        $this->args['page'] = isset($this->args['page']) ? $this->args['page'] : 0;
        
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

        $this->args['page'] = isset($this->args['page']) ? $this->args['page'] : 0;
        $this->args['page']++;
        
        return $this->request();
    }
}
