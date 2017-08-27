# wp-kit/acf-integration

This is a wp-kit component that handles [```ACF```](https://www.advancedcustomfields.com/) (Advanced Custom Fields) configuration via a [config file](config/acf.config.php).

This component was built to run within an [```Illuminate\Container\Container```](https://github.com/illuminate/container/blob/master/Container.php) so is perfect for frameworks such as [```Themosis```](http://framework.themosis.com/), [```Assely```](https://assely.org/) and [```wp-kit/theme```](https://github.com/wp-kit/theme).

This component is simply a [```ServiceProvider```](https://github.com/wp-kit/acf-integration/blob/master/src/Acf/AcfServiceProvider.php) which helps to simplify the configuration of ```ACF``` JSON paths and option pages.

## Installation

If you're using ```Themosis```, install via [```Composer```](https://getcomposer.org/) in the root of your ```Themosis``` installation, otherwise install in your ```Composer``` driven theme folder:

```php
composer require "wp-kit/acf-integration"
```

## Setup

### Add Service Provider

Just register the service provider in the providers config:

```php
//inside theme/resources/config/providers.config.php

return [
	//,
	WPKit\Integrations\Acf\AcfServiceProvider::class,   
	//
];
```

### Add Config File

The recommended method of installing config files for ```wp-kit``` components is via ```wp-kit/vendor-publish``` command.

First, [install WP CLI](http://wp-cli.org/), and then install the package via:

```wp package install wp-kit/vendor-publish```

Once installed you can run:

```wp kit vendor:publish```

For more information, please visit [wp-kit/vendor-publish](https://github.com/wp-kit/vendor-publish).

Alternatively, you can place the [config file(s)](config) in your ```theme/resources/config``` directory manually.

## Usage

Please install and study the default [config file](config/acf.config.php) as described above to learn how to use this component.

## Requirements

Wordpress 4+

ACF 4+

PHP 5.6+

## License

wp-kit/acf-integration is open-sourced software licensed under the MIT License.
