<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Class Namespace
    |--------------------------------------------------------------------------
    |
    | This value sets the root namespace for all of your Livewire components.
    | It is important that this is not changed after you start creating
    | components, as it would break component auto-discovery.
    |
    */

    'class_namespace' => 'App\\Livewire',

    /*
    |--------------------------------------------------------------------------
    | View Path
    |--------------------------------------------------------------------------
    |
    | This value sets the path where all of your Livewire component views will
    | be stored. It is important that this is not changed after you start
    | creating components, as it would break component auto-discovery.
    |
    */

    'view_path' => resource_path('views/livewire'),

    /*
    |--------------------------------------------------------------------------
    | Temporary File Uploads
    |--------------------------------------------------------------------------
    |
    | Livewire handles file uploads by storing the file in a temporary directory
    | before the file is stored permanently. The following options configure
    | the file upload functionality of Livewire.
    |
    */

    'temporary_file_upload' => [
        'disk' => null,                  // Example: 'local', 's3'              | Default: 'default' disk
        'rules' => 'file|max:25600',    // Example: 'file|mimes:png,jpg|max:1024' | Default: 'file|max:12288' (12MB)
        'directory' => null,             // Example: 'tmp'                      | Default: 'livewire-tmp'
        'middleware' => null,            // Example: 'throttle:5,1'             | Default: 'throttle:60,1'
        'preview_mimes' => [             // Supported file types for temporary pre-signed file URLs...
            'png', 'gif', 'bmp', 'svg', 'wav', 'mp4',
            'mov', 'avi', 'wmv', 'mp3', 'm4a',
            'jpg', 'jpeg', 'mpga', 'webp', 'wma',
        ],
        'max_upload_time' => 5,          // Max duration (in minutes) before an upload is invalidated...
    ],

    /*
    |--------------------------------------------------------------------------
    | Render On Redirect
    |--------------------------------------------------------------------------
    |
    | This value determines if Livewire will render a component when it is
    | redirected to. This is useful for pre-rendering a component that
    | will be displayed on the next page. 
    |
    */
    'render_on_redirect' => false,

];
