# WP Syde REST Enhancer

A modern, testable WordPress plugin that extends the REST API with additional endpoints and optimizations.

## Features

- Adds custom REST API endpoints
- Integrates with Stash caching for performance
- Built with Composer for dependency management
- Tested with PHPUnit and Brain Monkey

## Requirements

- PHP 8.1 or higher
- WordPress 6.0 or higher
- Composer
- Node.js (optional, if you manage assets)
- WP-CLI (optional)
- object-cache.php should be empty

## Installation

Next code should be added to wp-config:

define( 'WP_STASH_DRIVER', '\\Stash\\Driver\\FileSystem' );

define(
	'WP_STASH_DRIVER_ARGS',
	json_encode(
		array(
			'path'     => __DIR__ . '/wp-content/cache',
			'dirSplit' => 1,
		),
		JSON_THROW_ON_ERROR
	)
);

```bash
composer install
