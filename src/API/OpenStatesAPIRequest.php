<?php

namespace ejonasson\SunlightAPI\API;

use ejonasson\SunlightAPI\API\APIRequest;
use ejonasson\SunlightAPI\Exception\SunlightAPIException;

class OpenStatesAPIRequest extends APIRequest
{
    protected $url = 'http://openstates.org/api/v1/';

    public function getUrl()
    {
        return $this->url;
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
