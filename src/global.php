<?php

use Orchestra\Support\Facades\Acl;
use Orchestra\Support\Facades\App;
use Orchestra\Support\Facades\Config;

/*
|--------------------------------------------------------------------------
| Attach Memory to ACL
|--------------------------------------------------------------------------
*/

Acl::make('lckamal/navigation')->attach(App::memory());

/*
|--------------------------------------------------------------------------
| Allow Configuration to be managed via Database
|--------------------------------------------------------------------------
*/

Config::map('lckamal/navigation', array(
    'default_format' => 'lckamal/navigation::config.default_format',
    'per_page'       => 'lckamal/navigation::config.per_page',
));
