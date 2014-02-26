Navigation for Orchestra Story CMS
====================

Adds navigation with groups to your website.

###Features
- Multiple navigations on same page
- Supports Story CMS Page/Post links
- Supports site link(uri) and external links(url)
- Define targets (_self or _blank)
- Multple hierarchy navigation
- Customizable class options (helps on implementation for css frameworks like bootstrap). 
 

###Installation

Update ```app/start/global.php``` so that Orchestra\Platform is able to detect the extensions.

```php
App::make('orchestra.extension.finder')->addPath(base_path().'/extension/*/*/');
```
Add folder extension/lckamal on base path and add contents of this repo inside it.

Run ```php artisan dump-autoload``` to reload the autoloader.

Run ```php artisan extension:detect``` and you will see your newly created extension. All extensions will be created under ```extension``` directory.

###Usage
To render navigation on your site add

```php
Lckamal\Navigation\NavItem::render('abbrev');
```
abbrev is the slug of navigation group.

In addition you can add options for link classes
```php 
$options = array(
			'nav_class' => 'menu',
			'active_class' => 'active',
			'dropdown_class' => 'dropdown',
			'more_class' => 'dropdown-menu',
		);
		Lckamal\Navigation\NavItem::render('abbrev', $options);
```

This will generate menu like this
```
	<ul class="menu">
		<li class="">
			<a href="home">Home</a>
		</li>
		<li class="dropdown">
			<a href="about-us">About Us</a>
			<ul class=" dropdown-menu">
				<li class="services"><a href="">Services</a></li>
			</ul>
		</li>
	</ul>
```
