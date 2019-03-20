<?php

return [

    /*
     * Relative path from the app directory to api controllers directory.
     */
    'controllers_dir'  => 'Api/Controllers',

    /*
     * Relative path from the app directory to transformers directory.
     */
    'transformers_dir' => 'Api/Transformers',

    /*
     * Relative path from the app directory to the api routes file.
     */
    'routes_file'      => '../routes/api.php',

    /*
     * Relative path from the app directory to the models directory. Typically it's either 'Models' or ''.
     */
    'models_base_dir'  => '',

    /*
     * Relative path from the base directory to the api controller stub.
     */
    'controller_stub'  => 'vendor/arrilot/laravel-api-generator/src/Generator/stubs/controller.stub',

    /*
     * Relative path from the base directory to the route stub.
     */
    'route_stub'       => 'vendor/arrilot/laravel-api-generator/src/Generator/stubs/route.stub',

    /*
     * Relative path from the base directory to the transformer stub.
     */
    'transformer_stub' => 'vendor/arrilot/laravel-api-generator/src/Generator/stubs/transformer.stub',
];
