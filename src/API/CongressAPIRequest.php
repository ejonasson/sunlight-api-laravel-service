<?php

namespace ejonasson\SunlightAPI\API;

use ejonasson\SunlightAPI\API\APIRequest;
use ejonasson\SunlightAPI\Exception\SunlightAPIException;

class CongressAPIRequest extends APIRequest
{
    protected $url = 'https://congress.api.sunlightfoundation.com/';

    public function getUrl()
    {
        return $this->url;
    }

    public function requestAllPages()
    {
        $this->args = $args;
        // Get the first batch of responses, and the total count
        $response = $this->request($args);
        $results = $response->results;
        $count = $response->count;

        while ($count > $args['per_page']) {
            $count -= $args['per_page'];
            $response = $this->getNext();
            $results = array_merge($results, $response->results);
        }

        // Replace the merged results into the final $response object
        $response->results = $results;
        $this->response = $response;
        return $response;
    }

    public function getPrevious()
    {
        if (!$this->response) {
            throw new SunlightAPIException('Cannot use "getPrevious" without having run initial query');
        }

        $this->args['page']--;
        if ($this->args['page'] === 0) {
            $this->args['page'] = 1;
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
        $args['per_page'] = isset($args['per_page']) ? $args['per_page'] : 50;
        return $args;
    }
}
