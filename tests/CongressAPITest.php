<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use ejonasson\SunlightAPI\API\CongressAPIRequest;
use ejonasson\SunlightAPI\Exception\SunlightAPIException;
use ejonasson\SunlightAPI\Response\SunlightAPIResponse;

// Tests both the Default API functions and the Congress API Tests

class APITest extends TestCase
{
    public function setUp()
    {
        parent::setUp();
        // Make a Mock Request
        $this->setMockupRequest();
    }

    public function setMockupRequest()
    {
        $parameters = [
            'first_name' => 'John',
            'last_name' => 'Doe'
        ];
        $example_endpoint = 'legislators';
        $this->request = new CongressAPIRequest($example_endpoint, $parameters);
    }

    /**
     * Test the addParams method
     */
    public function testAddArgsToAPIRequest()
    {
        $new_args = [
            'party' => 'D'
        ];

        $merged_args = [
            'first_name' => 'John',
            'last_name' => 'Doe',
            'party'     => 'D',
            'page'      => 1,
            'per_page'  => 50,
        ];

        $this->request->addParams($new_args);
        $this->assertEquals($merged_args, $this->request->getParams());
    }
    /**
     * Test the Reset Params Feature
     */
    public function testResetParams()
    {
        $default_params = [
            'page' => 1,
            'per_page' => 50
        ];

        $this->request->resetParams();
        $this->assertEquals($this->request->getParams(), $default_params);
    }

    /**
     * Confirm that we are getting the API Key that's in the config file
     */
    public function testAPIKey()
    {
        $api_key = config('sunlightapi.sunlight_api_key');
        $this->assertEquals($this->request->getAPIKey(), $api_key);
    }
    
    public function testFailedRequests()
    {
        $this->expectException(SunlightAPIException::class);
        $bad_endpoint = 'BADENDPOINT';
        $this->request->setEndpoint($bad_endpoint);
        $response = $this->request->getResponse();
    }

    public function testSuccessfulRequests()
    {
        $this->setMockupRequest();
        $response = $this->request->getResponse();
        // Request Returns valid Response Class
        $this->assertInstanceOf(SunlightAPIResponse::class, $response);
    }
}
