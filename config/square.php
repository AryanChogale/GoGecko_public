<?php

return [
    'app_id'      => env('SQUARE_APP_ID'),
    'token'       => env('SQUARE_SANDBOX_TOKEN'),
    'location_id' => env('SQUARE_LOCATION_ID'),
    'environment' => env('SQUARE_ENVIRONMENT', 'sandbox'),
    'base_url'    => env('SQUARE_ENVIRONMENT', 'sandbox') === 'sandbox'
                        ? 'https://connect.squareupsandbox.com'
                        : 'https://connect.squareup.com',
];
