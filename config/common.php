<?php

return [
    'api_version' => '1.0.0',
    'route_prefix' => [
        'v1' => 'v1',
    ],
    'sources' => [
        'web' => 'web',
        'mobile' => 'mobile',
    ],

    'token_names' => [
        'server' => 'AppName',
    ],

    'guard_api_session' => 'apiauthweb',
    'guard_api_passport' => 'apiauth',
    'guard_auth_server_session' => 'serverauthweb',
    'guard_auth_server_passport' => 'serverauth',

    'default_date_format' => 'D MMM YYYY',
    'default_datetime_format' => 'D MMM YYYY, HH:mm:ss',

    'backoffice_url' => env('BACKOFFICE_URL', ''),
    'front_url' => env('FRONT_URL', 'http://localhost'),

    'disk' => 'anged_files',

    'login_attempts_time' => env('LOGIN_ATTEMPTS_TIME', 1),
    'minutes_to_add_to_activation_token' => env('MINUTES_TO_ADD_TO_ACTIVATION_TOKEN', 15),

    'variable_template_email' => [
        'forgot_password' => '{{url_reset_password}}',
        'user_credential' => '{{user_credential}}',
        'created_user_name' => '{{created_user_name}}',
        'login_url' => '{{login_url}}',
        'lien' => '{{lien}}',
    ],

    'routes' => [
        'forgot_password' => 'reset-password',
    ],
];
