<?php
/**
 * Bootstrap the plugin unit testing environment.
 */

// eg set WP_DEVELOP_DIR=D:\workspace\wordpress-develop\branches\4.1
if( false !== getenv( 'WP_DEVELOP_DIR' ) ) {
    $test_root = getenv( 'WP_DEVELOP_DIR' );
} else {
    $test_root = dirname( __FILE__ ) . '/../../wordpress-develop/trunk';
}
require $test_root . '/tests/phpunit/includes/functions.php';

// Activates this plugin in WordPress so it can be tested.
function _manually_load_plugin() {
	require dirname( __FILE__ ) . '/../run-route.php';
}
tests_add_filter( 'plugins_loaded', '_manually_load_plugin' );

require $test_root . '/tests/phpunit/includes/bootstrap.php';