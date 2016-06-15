<?php

namespace ejonasson\SunlightAPI\API;

use GuzzleHttp;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Exception\RequestException;
use Cache;
use Carbon\Carbon;

use ejonasson\SunlightAPI\Exception\SunlightAPIException;
use ejonasson\SunlightAPI\Response\SunlightAPIResponse;

abstract class APIRequest
{
    protected $api_key;
    protected $response;
    protected $endpoint;
    protected $args;
    protected $request_type;

    public function __construct($endpoint = '', $args = array())
    {
        $this->api_key = config('sunlightapi.sunlight_api_key');
        $this->endpoint = $endpoint;
        $this->args = $this->setInitialArgs($args);
    }

    abstract public function getUrl();
    abstract public function getPrevious();
    abstract public function getNext();

    public function get()
    {
        return $this->getResponse();
    }

    public function getApiKey()
    {
        return $this->api_key;
    }

    public function getResponse()
    {
        if ($this->checkCache()) {
            $this->response = $this->getCachedResult();
            return $this->response;
        }

        if (!$this->response) {
            $this->response = $this->request();
        }

        $this->cacheResponse();
        return $this->response;
    }

    public function request($args = array(), $use_cache = true)
    {
        if (empty($this->endpoint)) {
            throw new SunlightAPIException('Cannot make API Request: No Endpoint set.');
        }

        if (empty($args)) {
            $args = $this->args;
        }
        $url = $this->getUrl() . $this->endpoint . $this->encodeArgs($args);
        $client = new GuzzleHttp\Client(['base_uri' => $url]);
        try {
            $res = $client->request('GET', '', [
                'headers' => [
                            'X-APIKEY' => $this->getApiKey()
                            ]
                ]);
            if ($this->responseIsJSON($res)) {
                $data = json_decode($res->getBody());
                $this->response = new SunlightAPIResponse($data);
                return $this->response;
            } else {
                throw new SunlightAPIException('Valid JSON not retreived by API');
            }
        } catch (RequestException $e) {
            throw new SunlightAPIException($e->getMessage());
        }
    }

    public function addParams(array $params)
    {
        $this->args = array_merge($params, $this->args);
        return $this;
    }

    public function getParams()
    {
        return $this->args;
    }

    public function setEndpoint($endpoint)
    {
        $this->endpoint = $endpoint;
        return $this;
    }

    /**
     * Reset Parameters to the default Argusments
     * @return $this
     */
    public function resetParams()
    {
        $this->args = [];
        $this->args = $this->setInitialArgs($this->args);
        return $this;
    }

    protected function encodeArgs($args)
    {
        $output = '?';
        foreach ($args as $key => $value) {
            $string = $key . '=' . $value . '&';
            $output .= $string;
        }
        return $output;
    }

    protected function responseIsJson($response)
    {
        $results = json_decode($response->getBody());
        if (json_last_error() == JSON_ERROR_NONE) {
            return true;
        }
        return false;
    }

    /**
     * Set any default arguments for this API Here
     * Override this function in the parent if there are additional default args
     * @param array $args
     */
    protected function setInitialArgs($args)
    {
        return $args;
    }

    /* --------------------------------------------------------------------
        Caching Functionality for API Responses
    ------------------------------------------------------------------------------*/
    protected function checkCache()
    {
        $cache_name = $this->getCacheName();
        return Cache::has($cache_name);
    }

    protected function getCachedResult()
    {
        $cache_name = $this->getCacheName();
        return Cache::get($cache_name);
    }

    protected function cacheResponse()
    {
        $cache_name = $this->getCacheName();
        $cache_duration = config('sunlightapi.cache_duration', 60);
        $expires = Carbon::now()->addMinutes($cache_duration);
        if ($cache_duration > 0) {
            Cache::put($cache_name, $this->response, $expires);
        }

        return $this->response;
    }

    protected function getCacheName()
    {
        // Generate a MD5 hash as a cache name
        // This hash combines a serialization of the $args array, along with the endpoint name
        // Along with the endpoint URL
        // So identical requests should match this hash
        $args_string = serialize($this->args);
        $hash_string = $this->url . $args_string . $this->endpoint;
        $cache_name = 'SunlightAPIRequest_' . md5($hash_string);
        return $cache_name;
    }
}
