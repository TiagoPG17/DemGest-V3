<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Image Driver
    |--------------------------------------------------------------------------
    |
    | Intervention Image supports "GD Library" and "Imagick" to process images
    | internally. You may choose one of them according to your PHP
    | configuration. By default, PHP's "GD Library" implementation is used.
    |
    | Supported: "gd", "imagick"
    |
    */

    'driver' => 'gd',

    /*
    |--------------------------------------------------------------------------
    | Image Cache
    |--------------------------------------------------------------------------
    |
    | Here you may specify if you want to use image cache for faster image
    | processing. Set this to true to enable image caching.
    |
    */

    'cache' => false,

    /*
    |--------------------------------------------------------------------------
    | Image Cache Path
    |--------------------------------------------------------------------------
    |
    | This is the path where the image cache will be stored if caching is
    | enabled. Make sure this directory is writable by the web server.
    |
    */

    'cache_path' => storage_path('framework/cache'),

    /*
    |--------------------------------------------------------------------------
    | Image Cache Lifetime
    |--------------------------------------------------------------------------
    |
    | Here you may specify the number of minutes the image cache should be
    | kept. This is only used if caching is enabled.
    |
    */

    'cache_lifetime' => 60 * 24 * 7, // 1 week

    /*
    |--------------------------------------------------------------------------
    | Image Quality
    |--------------------------------------------------------------------------
    |
    | Here you may specify the default quality for the image manipulation.
    | This is only used for the GD driver.
    |
    */

    'quality' => 90,

    /*
    |--------------------------------------------------------------------------
    | Image Sizes
    |--------------------------------------------------------------------------
    |
    | Here you may specify the default sizes for the image manipulation.
    | These sizes will be used when no specific size is provided.
    |
    */

    'sizes' => [
        'small' => [
            'width' => 200,
            'height' => 200,
            'crop' => true,
        ],
        'medium' => [
            'width' => 500,
            'height' => 500,
            'crop' => true,
        ],
        'large' => [
            'width' => 800,
            'height' => 800,
            'crop' => true,
        ],
    ],
];
