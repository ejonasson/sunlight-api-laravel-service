<?php

namespace ejonasson\SunlightAPI\API;

use ejonasson\SunlightAPI\API\APIRequest;
use ejonasson\SunlightAPI\Exception\SunlightAPIException;

class PartyTimeAPIRequest extends APIRequest
{
    protected $url = 'http://politicalpartytime.org/api/v1/';

    public function getUrl()
    {
        return $this->url;
    }

    public function setInitialArgs($args)
    {
        $args['format'] = isset($args['format']) ? $args['format'] : 'json';
        return $args;
    }

    public function getNext()
    {
        if (!$this->response) {
            throw new SunlightAPIException('Cannot use "getNext" without having run initial query');
        }
        $this->args['limit'] = $this->response->meta->limit;
        $this->args['offset'] = $this->response->meta->offset + $this->args['limit'];

        return $this->request();
    }

    public function getPrevious()
    {
        if (!$this->response) {
            throw new SunlightAPIException('Cannot use "getPrevious" without having run initial query');
        }

        $this->args['limit'] = $this->response->meta->limit;
        $this->args['offset'] = $this->response->meta->offset - $this->args['limit'];

        if ($this->args['offset'] < 0) {
            $this->args['offset'] = 0;
        }

        return $this->request();
    }
}
