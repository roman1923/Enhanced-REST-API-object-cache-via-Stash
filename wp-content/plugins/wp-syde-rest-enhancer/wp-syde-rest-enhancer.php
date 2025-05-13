<?php

/**
 * Plugin Name:       Syde REST Enhancer
 * Description:       Enhanced REST API & object cache via Stash
 * Version:           1.0.0
 * Author:            Roman Zhurakivskyi
 * Requires PHP:      8.1
 * Requires at least: 6.1
 */

declare(strict_types=1);

namespace Syde\RestEnhancer;

use Syde\RestEnhancer\Infrastructure\ContainerBuilder;
use Syde\RestEnhancer\Infrastructure\RouteRegistrar;

defined('ABSPATH') || exit;

$autoload = ABSPATH . 'vendor/autoload.php';
if (! is_readable($autoload)) {
    error_log('Syde REST Enhancer: Composer autoload not found at WP root. Plugin not loaded.');
    return;
}
require_once $autoload;

add_action('rest_api_init', static function (): void {
    $container = (new ContainerBuilder())->build();
    $container->get(RouteRegistrar::class)->register();
});

add_action('init', function () {
    wp_cache_set('test_key', 'cached value', 'default', 60);
    $value = wp_cache_get('test_key', 'default');
    error_log('Cache value: ' . $value);
});
