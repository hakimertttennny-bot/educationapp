<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Cookie Name
    |--------------------------------------------------------------------------
    |
    | This name is used by the framework to name cookies that are created
    | by the framework. You can change this name if you want to use a
    | different name for cookies created by the framework.
    |
    */

    'name' => env('COOKIE_NAME', 'laravel_cookie'),

    /*
    |--------------------------------------------------------------------------
    | Cookie Path
    |--------------------------------------------------------------------------
    |
    | The path determines the path for which the cookie will be regarded
    | as available. Typically, this will be the root path of your app
    | but you are free to change this when necessary.
    |
    */

    'path' => '/',

    /*
    |--------------------------------------------------------------------------
    | Cookie Domain
    |--------------------------------------------------------------------------
    |
    | Here you may change the domain of the cookie used to identify a
    | session in your application. This will determine which domains
    | the cookie is available to in your application.
    |
    */

    'domain' => env('COOKIE_DOMAIN'),

    /*
    |--------------------------------------------------------------------------
    | HTTPS Only Cookies
    |--------------------------------------------------------------------------
    |
    | By setting this option to true, cookies will only be sent back to
    | the server if the browser has a HTTPS connection. This will keep
    | the cookie from being sent to you when it can't be done securely.
    |
    */

    'secure' => env('COOKIE_SECURE', false),

    /*
    |--------------------------------------------------------------------------
    | HTTP Access Only
    |--------------------------------------------------------------------------
    |
    | Setting this value to true will prevent JavaScript from accessing the
    | value of the cookie and the cookie will only be accessible through
    | the HTTP protocol. You are free to modify this option if needed.
    |
    */

    'http_only' => true,

    /*
    |--------------------------------------------------------------------------
    | Same-Site Cookies
    |--------------------------------------------------------------------------
    |
    | This option determines how your cookies behave when cross-site requests
    | take place, and can be used to mitigate CSRF attacks. By default, we
    | will set this value to "lax" since this is a secure default value.
    |
    | Supported: "lax", "strict", "none", null
    |
    */

    'same_site' => 'lax',

];


