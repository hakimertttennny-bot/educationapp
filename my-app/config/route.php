<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Route Rate Limiting
    |--------------------------------------------------------------------------
    |
    | Here you may configure rate limiting for your application's routes.
    | You can define rate limiters for different route groups and
    | customize the rate limiting behavior.
    |
    */

    'throttle' => [
        'api' => [
            'driver' => 'throttle',
            'max_attempts' => 60,
            'decay_minutes' => 1,
        ],
        'login' => [
            'driver' => 'throttle',
            'max_attempts' => 5,
            'decay_minutes' => 15,
        ],
    ],

];
