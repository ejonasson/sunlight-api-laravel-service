<?php

// Assign the API Object to $request
$request = \SunlightAPI::makeRequest('congress');
// Set the endpoint of your request
$request->setEndpoint('legislators');
// Filter the API Request to return only Democrat Legislators
$request->setParam(['party' => 'D']);
// Run the API Query
$legislators = $request->get();
// Get the Second Page of Democrat Legislators
$more_legislators = $request->getNext();
// Dump the result
dd($more_legislators);
