<?php

// Use the CampaignFinance API To get all the expenditures for the state of Florida.

// Set the Endpoint to '/districts/'
$endpoint = 'districts';
// Create the parameters array
$params = [
    'state' => 'FL'
];
// Generate the request object
$request = \SunlightAPI::makeRequest('campaign-finance', $endpoint, $params);
// Dump the result
dd($request->get());
