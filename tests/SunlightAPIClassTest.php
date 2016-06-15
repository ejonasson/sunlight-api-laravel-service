<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use ejonasson\SunlightAPI\SunlightAPI;
use ejonasson\SunlightAPI\API\CongressAPIRequest;
use ejonasson\SunlightAPI\API\CapitolWordsAPIRequest;
use ejonasson\SunlightAPI\API\OpenStatesAPIRequest;
use ejonasson\SunlightAPI\API\PartyTimeAPIRequest;
use ejonasson\SunlightAPI\API\CampaignFinanceAPIRequest;
use ejonasson\SunlightAPI\Exception\SunlightAPIException;

class SunlightAPIClassTest extends TestCase
{
    public function testCorrectClassIsCalled()
    {
        $congress = \SunlightAPI::makeRequest('congress');
        $this->assertInstanceOf(CongressAPIRequest::class, $congress);

        $capitol_words = \SunlightAPI::makeRequest('capitol-words');
        $this->assertInstanceOf(CapitolWordsAPIRequest::class, $capitol_words);

        $open_states = \SunlightAPI::makeRequest('open-states');
        $this->assertInstanceOf(OpenStatesAPIRequest::class, $open_states);

        $party_time = \SunlightAPI::makeRequest('political-party-time');
        $this->assertInstanceOf(PartyTimeAPIRequest::class, $party_time);

        $campaign_finance = \SunlightAPI::makeRequest('campaign-finance');
        $this->assertInstanceOf(CampaignFinanceAPIRequest::class, $campaign_finance);
    }
}
