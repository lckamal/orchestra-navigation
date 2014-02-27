Navigation for Orchestra Platform
====================

Add navigation with groups to your Orchestra Platform website.

## Features
- Database driven Navigation
- Multiple navigations on same page
- Supports Story CMS Page/Post links
- Supports site link(uri) and external links(url)
- Define targets (_self or _blank)
- Multple hierarchy navigation
- Customizable class options (helps on implementation for css frameworks like bootstrap).
- Can be used as database driven orchestra extension navigation
 

## Installation

To install through composer, simply put the following in your `composer.json` file:

```json
{
	"require": {
		"lckamal/orchestra-navigation": "dev-master"	
	},
	"repositories": [
		{
			"type": "vcs",
			"url": "git://github.com/lckamal/orchestra-navigation"
		}
	]
}
```

Run ```composer update``` to install the extension.

Run ```php artisan extension:detect``` and you will see your newly created extension. All extensions will be created under ```extension``` directory.

## Usage

To render navigation on your site add

```php
echo Lckamal\Navigation\NavItem::render('abbrev');
```

abbrev is the slug of navigation group.

In addition you can add options for link classes

```php 
$options = array(
	'nav_class' => 'menu',
	'active_class' => 'active',
	'dropdown_class' => 'dropdown',
	'more_class' => 'dropdown-menu',
	'dropdown_toggle_attr' => 'data-toggle="dropdown"'
);
echo Lckamal\Navigation\NavItem::render('abbrev', $options);
```

This will generate menu like this

```
	<ul class="menu">
		<li class="">
			<a href="home">Home</a>
		</li>
		<li class="dropdown">
			<a href="about-us" data-toggle="dropdown">About Us</a>
			<ul class=" dropdown-menu">
				<li class="services"><a href="">Services</a></li>
			</ul>
		</li>
	</ul>
```