<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Encryption Key
    |--------------------------------------------------------------------------
    |
    | This key is used by the Illuminate encrypter service and should be set
    | to a random, 32 character string, otherwise these encrypted strings
    | will not be safe. Please do this before deploying an application!
    |
    */

    'key' => env('APP_KEY'),

    /*
    |--------------------------------------------------------------------------
    | Cipher
    |--------------------------------------------------------------------------
    |
    | This option controls the encryption cipher that will be used by the
    | encrypter service. This cipher is used when encrypting values and
    | should be supported by the OpenSSL extension installed on your
    | server. The default cipher is AES-256-CBC.
    |
    */

    'cipher' => 'AES-256-CBC',

];


