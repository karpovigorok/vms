<?php

return [

    /* -----------------------------------------------------------------
     |  Database
     | -----------------------------------------------------------------
     */

    'database' => [
        'connection' => null,

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

        'default' => 'config',

        'drivers' => [
            'config' => [
                'class'   => Arcanedev\LaravelSeo\Redirectors\ConfigurationRedirector::class,

                'options' => [
                    'redirects' => [
//                        '/non-existing-page-url' => '/existing-page-url',
//                        '/old-blog/{slug}'       => '/new-blog/{slug}',
                    ],
                ],
            ],

            'eloquent' => [
                'class'   => Arcanedev\LaravelSeo\Redirectors\EloquentRedirector::class,

                'options' => [
                    'cache' => [
                        'key'      => 'seo-redirects',
                        'duration' => 30, // minutes
                    ],
                ],
            ],
        ],
    ],

];
