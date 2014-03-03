<?php

use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\View;
use Orchestra\Support\Facades\Asset;
use Orchestra\Support\Facades\Widget;

/*
|--------------------------------------------------------------------------
| Attach multiple widget for Story CMS
|--------------------------------------------------------------------------
*/

Event::listen('orchestra.form: extension.lckamal/navigation', function () {
    $placeholder = Widget::make('placeholder.orchestra.extensions');
    $placeholder->add('permalink')->value(View::make('lckamal/navigation::widgets.help'));
});
/*
|--------------------------------------------------------------------------
| Attach Configuration Callback
|--------------------------------------------------------------------------
*/


/*
|--------------------------------------------------------------------------
| Add asset for Markdown Editing
|--------------------------------------------------------------------------
|
| Load asset based on for markdown.
|
*/


