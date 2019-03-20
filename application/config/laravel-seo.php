<?php

return [

    /* -----------------------------------------------------------------
     |  Database
     | -----------------------------------------------------------------
     */

    'database' => [
        'connection' => 'mysql',

        'prefix'     => 'seo_',
    ],

    /* -----------------------------------------------------------------
     |  Tables
     | -----------------------------------------------------------------
     */

    'metas'     => [
        'table' => 'metas',
        'model' => Arcanedev\LaravelSeo\Models\Meta::class,
    ],

    'redirects' => [
        'table' => 'redirects',
        'model' => Arcanedev\LaravelSeo\Models\Redirect::class,
    ],

    /* -----------------------------------------------------------------
     |  Redirector
     | -----------------------------------------------------------------
     */

    'redirector' => [
        'enabled' => true,
        'default' => 'eloquent',
        'drivers' => [
//            'config' => [
//                'class'   => Arcanedev\LaravelSeo\Redirectors\ConfigurationRedirector::class,
//
//                'options' => [
//                    'redirects' => [
//                        '/sdfsdfsdf' => '/video/98',
////                        '/old-blog/{slug}'       => '/new-blog/{slug}',
//                    ],
//                ],
//            ],

            'eloquent' => [
                'class'   => Arcanedev\LaravelSeo\Redirectors\EloquentRedirector::class,
                'options' => [
                    'cache' => [
                        'key'      => 'seo-redirects',
                        'duration' => 0, // minutes
                    ],
                ],
            ],
        ],
    ],

];
