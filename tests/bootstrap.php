<?php

/**
 * Set up environment for my plugin's tests suite.
 */

/**
 * The path to the WordPress tests checkout.
 */
// tested with tags 3.7, 3.8, 3.9, 4.0 and trunk
// NB: need to enable php_mysql.dll in php.ini for 3.7 and 3.8
define( 'WP_TESTS_DIR', '../wordpress-develop/tags/4.0/tests/phpunit/' );

/**
 * The path to the main file of the plugin to test.
 */
define( 'TEST_PLUGIN_FILE', '../run-route/trunk/run-route.php' );



/**
 * The WordPress tests functions.
 *
 * We are loading this so that we can add our tests filter
 * to load the plugin, using tests_add_filter().
 */
require_once WP_TESTS_DIR . 'includes/functions.php';

/**
 * Manually load the plugin main file.
 *
 * The plugin won't be activated within the test WP environment,
 * that's why we need to load it manually.
 *
 * You will also need to perform any installation necessary after
 * loading your plugin, since it won't be installed.
 */
function _manually_load_plugin() {

    require TEST_PLUGIN_FILE;

    // Make sure plugin is installed here ...
}
tests_add_filter( 'muplugins_loaded', '_manually_load_plugin' );

/**
 * Sets up the WordPress test environment.
 *
 * We've got our action set up, so we can load this now,
 * and viola, the tests begin.
 */
require WP_TESTS_DIR . 'includes/bootstrap.php';