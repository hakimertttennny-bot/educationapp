<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Route Model Binding
    |--------------------------------------------------------------------------
    |
    | This option controls how route model binding works. By default, Laravel
    | will attempt to find a model that matches the route parameter name.
    | You can override this behavior by setting this option to false.
    |
    */

    'model_binding' => true,

    /*
    |--------------------------------------------------------------------------
    | Route Caching
    |--------------------------------------------------------------------------
    |
    | This option controls whether routes are cached. When enabled, routes
    | are cached in memory for faster performance. This is especially
    | useful in production environments.
    |
    */

    'cache' => env('ROUTE_CACHE', false),

    /*
    |--------------------------------------------------------------------------
    | Route Model Binding Cache
    |--------------------------------------------------------------------------
    |
    | This option controls whether route model binding results are cached.
    | When enabled, the results of route model binding are cached for
    | faster performance on subsequent requests.
    |
    */

    'model_binding_cache' => env('ROUTE_MODEL_BINDING_CACHE', false),

    /*
    |--------------------------------------------------------------------------
    | Route Parameter Binding
    |--------------------------------------------------------------------------
    |
    | This option controls how route parameters are bound to models. By
    | default, Laravel will attempt to find a model that matches the
    | route parameter name. You can override this behavior by setting
    | this option to false.
    |
    */

    'parameter_binding' => true,

];


