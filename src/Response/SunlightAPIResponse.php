<?php

namespace ejonasson\SunlightAPI\Response;

class SunlightAPIResponse
{
    public function __construct($data)
    {
        // Map Response object to current object
        foreach (get_object_vars($data) as $key => $value) {
            $this->$key = $value;
        }
    }
}
