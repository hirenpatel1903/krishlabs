<?php
use Illuminate\Validation\Rule;

return [

    /*
    |--------------------------------------------------------------------------
    | Server Requirements
    |--------------------------------------------------------------------------
    |
    | This is the default Laravel server requirements, you can add as many
    | as your application require, we check if the extension is enabled
    | by looping through the array and run "extension_loaded" on it.
    |
    */
    'core' => [
        'minPhpVersion' => '7.2.0',
    ],
    'final' => [
        'key' => true,
        'publish' => false,
    ],
    'requirements' => [
        'php' => [
            'openssl',
            'pdo',
            'mbstring',
            'tokenizer',
            'JSON',
            'cURL',
            'xml',
            'Ctype',
            'BCMath',
            'Zip'
        ],
        'apache' => [
            'mod_rewrite',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Folders Permissions
    |--------------------------------------------------------------------------
    |
    | This is the default Laravel folders permissions, if your application
    | requires more permissions just add them to the array list bellow.
    |
    */
    'permissions' => [
        'storage/framework/'     => '775',
        'storage/logs/'          => '775',
        'bootstrap/cache/'       => '775',
    ],

    /*
    |--------------------------------------------------------------------------
    | Environment Form Wizard Validation Rules & Messages
    |--------------------------------------------------------------------------
    |
    | This are the default form field validation rules. Available Rules:
    | https://laravel.com/docs/5.4/validation#available-validation-rules
    |
    */
    'environment' => [
        'form' => [
            'rules' => [
                'app_name'              => 'required|string|max:50',
                'environment'           => 'required|string|max:50',
                'environment_custom'    => 'required_if:environment,other|max:50',
                'app_debug'             => [
                    'required',
                ],
                'app_log_level'         => 'required|string|max:50',
                'app_url'               => 'required|url',
                'database_connection'   => 'required|string|max:50',
                'database_hostname'     => 'required|string|max:50',
                'database_port'         => 'required|numeric',
                'database_name'         => 'required|string|max:50',
                'database_username'     => 'required|string|max:50',
                'database_password'     => 'nullable|string|max:50',
            ],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Installed Middleware Options
    |--------------------------------------------------------------------------
    | Different available status switch configuration for the
    | canInstall middleware located in `canInstall.php`.
    |
    */
    'installed' => [
        'redirectOptions' => [
            'route' => [
                'name' => 'home',
                'data' => [],
            ],
            'abort' => [
                'type' => '404',
            ],
            'dump' => [
                'data' => 'Dumping a not found message.',
            ],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Selected Installed Middleware Option
    |--------------------------------------------------------------------------
    | The selected option fo what happens when an installer instance has been
    | Default output is to `/resources/views/error/404.blade.php` if none.
    | The available middleware options include:
    | route, abort, dump, 404, default, ''
    |
    */
    'installedAlreadyAction' => 'route',

    /*
    |--------------------------------------------------------------------------
    | Updater Enabled
    |--------------------------------------------------------------------------
    | Can the application run the '/update' route with the migrations.
    | The default option is set to False if none is present.
    | Boolean value
    |
    */
    'updaterEnabled' => 'true',

    /* purchase code verification objects */

    'item_name' => 'QuickStore',
    /*
     |-----------------------------------------------------------------------------------------------
     | The item's version on CodeCanyon
     |-----------------------------------------------------------------------------------------------
     |
     */

    'item_version' => '1.0',

    /*
     |-----------------------------------------------------------------------------------------------
     | The item's ID on CodeCanyon
     |-----------------------------------------------------------------------------------------------
     |
     */

    'itemId' => '24643230',

    /*
     |-----------------------------------------------------------------------------------------------
     | Purchase code checker URL
     |-----------------------------------------------------------------------------------------------
     |
     */

    'purchaseCodeCheckerUrl' => 'https://demo.inilabs.net/tracker/api/check',
    /*
     |-----------------------------------------------------------------------------------------------
     | Purchase Code
     |-----------------------------------------------------------------------------------------------
     |
     */

    'purchaseCode' => env('PURCHASE_CODE', ''),

    /*
     |-----------------------------------------------------------------------------------------------
     | Demo Website Info
     |-----------------------------------------------------------------------------------------------
     |
     */

    'demo' => [
        'domain' => 'https://dev.quickstore.xyz/',
        'hosts'   => [
            'https://dev.quickstore.xyz',
        ],
    ],


];
