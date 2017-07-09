# WPKit ACF Integration

This is a Wordpress PHP Component to handle ACF Configuration. 

This PHP Component was built to run within an Illuminate Container so is perfect for frameworks such as Themosis.

This Components is very small and is simply a Service Provider which helps to simplify the configuration of ACF JSON Path and Options Page.

## Installation

If you're using Themosis, install via composer in the Themosis route folder, otherwise install in your theme folder:

```php
composer require "wp-kit/acf-integration"
```

## Registering Service Provider

**Within Themosis Theme**

Just register the service provider in the providers config:

```php
//inside themosis-theme/resources/config/providers.config.php

return [
	//,
	WPKit\Integrations\Acf\AcfServiceProvider::class,   
	//
];
```

**Within functions.php**

If you are just using this component standalone then add the following the functions.php

```php
// within functions.php

// make sure composer has been installed
if( ! file_exists( __DIR__ . '/vendor/autoload.php' ) ) {
	
	wp_die('Composer has not been installed, try running composer', 'Dependancy Error');
	
}

// Use composer to load the autoloader.
require __DIR__ . '/vendor/autoload.php';

$container = new Illuminate\Container\Container(); // create new app container

$provider = new WPKit\Integrations\Acf\AcfServiceProvider($container); // inject into service provider

$provider->register(); //register service provider
```


## Config

Now just add the configuration file in your config directory:

```php
// In theme/resources/config/acf.config.php

return [

    /*
    |--------------------------------------------------------------------------
    | ACF Options Args
    |--------------------------------------------------------------------------
    |
    | Tell the Service Provider which pages to register in the admin area
    |
    */

    'pages' => [
	    [
		    'type' => 'page',
		    'args => [
				// see https://www.advancedcustomfields.com/resources/acf_add_options_page/
			]
	    ],
	    [
		    'type' => 'subpage',
		    'args' => [
			    // see https://www.advancedcustomfields.com/resources/acf_add_options_sub_page/
			]
		]
    ],

    /*
    |--------------------------------------------------------------------------
    | ACF JSON Path
    |--------------------------------------------------------------------------
    |
    | Tell the Server Provider where to find JSON files to save and load
    | configurations from. By default the below function loads from:
    |
    | ~/theme/resources/acf/
    |
    */

    'json_path' => resources_path('acf')

];

```

## Requirements

Wordpress 4+

ACF 4+

PHP 5.6+

## License

WPKit ACF Integration is open-sourced software licensed under the MIT License.
