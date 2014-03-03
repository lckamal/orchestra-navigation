<?php

use Orchestra\Support\Facades\App;
use Orchestra\Support\Facades\Resources;

/*
|--------------------------------------------------------------------------
| Navigation Resources Route
|--------------------------------------------------------------------------
|
| Register Navigation Extension as a resources.
|
*/

Event::listen('orchestra.started: admin', function () {
    $control = Resources::make('navigation', array(
        'name'    => 'Navigation',
        'uses'    => 'restful:Lckamal\Navigation\Controller\HomeController',
        'visible' => Auth::check()
    ));

    $control['links']  = 'resource:Lckamal\Navigation\Controller\NavigationsController';
    $control['groups']  = 'resource:Lckamal\Navigation\Controller\NavigationsGroupController';
});
