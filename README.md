Navigation for Orchestra Story CMS
====================

Adds navigation with groups to your website.


### Installation & Usage

Update ```app/start/global.php``` so that Orchestra\Platform is able to detect the extensions.

```php
App::make('orchestra.extension.finder')->addPath(base_path().'/extension/*/*/');
```
Add folder extension/lckamal on base path and add contents of this repo inside it.

Run ```php artisan dump-autoload``` to reload the autoloader.

Run ```php artisan extension:detect``` and you will see your newly created extension. All extensions will be created under ```extension``` directory.

###TODO
- Generate navigation with helper on frontend
