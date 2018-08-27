<?php

return [

    /*
    |--------------------------------------------------------------------------
    | CloudSearch State
    |--------------------------------------------------------------------------
    |
    | This is here to help with local development. It can be a little tough
    | working with CloudSearch on a local machine.
    */

    'enabled' => true,

    /*
    |--------------------------------------------------------------------------
    | Custom CloudSearch Client Configuration
    |--------------------------------------------------------------------------
    |
    | This array will be passed to the CloudSearch client.
    |
    */

    'config' => [
        'endpoint' => env('CLOUDSEARCH_ENDPOINT'),
        'region' => env('CLOUDSEARCH_REGION'),

        'credentials' => [
            'key'      => env('AWS_KEY'),
            'secret'   => env('AWS_SECRET')
        ],

        'version'  => '2013-01-01',
    ],

    /*
    |--------------------------------------------------------------------------
    | Domain Name
    |--------------------------------------------------------------------------
    |
    | The domain name used for the searching.
    |
    */

    'domain_name' => 'masharee3',

    /*
    |--------------------------------------------------------------------------
    | Index Fields
    |--------------------------------------------------------------------------
    |
    | This is used to specify your index fields and their data types.
    |
    */

    'fields' => [
        'id' => 'literal',
        'name' => 'text',
        'speciality' => 'text-array',
        'industry_name' => 'text',
        'industry_id' => 'literal',
        'industry_slug' => 'text',
        'relevance_score' => 'text',
        'is_promoted' => 'text',
        'created_at' => 'text',
        'status' => 'text',
        'city' => 'text',
        'slug' => 'text',
    ],

    /*
    |--------------------------------------------------------------------------
    | Model Namespace
    |--------------------------------------------------------------------------
    |
    | Change this if you use a different model namespace for Laravel.
    |
    */

    'model_namespace' => '\\App',

    /*
    |--------------------------------------------------------------------------
    | Support Locales
    |--------------------------------------------------------------------------
    |
    | This is used in the command line to import and map models.
    |
    */

    'support_locales' => [],

    /*
    |--------------------------------------------------------------------------
    | Batching
    |--------------------------------------------------------------------------
    |
    | In this section we can customize a few of the settings that in the long
    | run could save us some money.
    |
    */

    'batching_size' => 100,

];
