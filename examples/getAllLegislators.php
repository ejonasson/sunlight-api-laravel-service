<?php
// Assign the API Object to $request
$request = \SunlightAPI::makeRequest('congress');
// Set the endpoint of your request
$request->setEndpoint('legislators');

// Get the first batch of responses, and the total count
$response = $request->get();
// Assign the results to a variable
$results = $response->results;
// Register the "Count" that's returned from the initial request
$count = $response->count;

// Loop through the pages and add merge each response with the first response
while ($count > 50) { # 50 is the default per_page value
    $response = $request->getNext(); # Get the next page
    $count -= 50; # reduce the count to account for new data
    $results = array_merge($results, $response->results);
}

// Replace the merged results into the $response object
$response->results = $results;
// Dump the response
dd($response);